<?php

namespace App\Http\Controllers;

use App;
use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Index */
    public function index()
    {
        // Retrieve list of ads
        $ads = Ad::orderBy('title', 'asc')->get();

        // Return view
        return view('adminlte::ads.index', compact('ads'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve ad details
        $ad = Ad::find($id);

        // Return 404 page if ad not found
        if ($ad == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::ads.edit', compact('ad', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        // Retrieve ad details
        $ad = Ad::find($id);

        $ad->code = $request->get('code');
        $ad->save();

        // Clear cache
        Cache::flush();

        // Redirect to ad edit page
        return redirect()->route('ads.edit', $ad->id)->with('success', 'Data Updated');
    }

}
