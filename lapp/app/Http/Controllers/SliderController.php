<?php

namespace App\Http\Controllers;

use App;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

class SliderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // List of sliders
        $sliders = Slider::orderBy('id', 'DESC')->paginate(10);

        // List of applications
        $apps = DB::table('applications')->orderBy('title', 'asc')->get();

        // Pass data to views
        View::share(['sliders' => $sliders, 'apps' => $apps]);
    }

    /** Index */
    public function index()
    {
        // Return view
        return view('adminlte::sliders.index');
    }

    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::sliders.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'link' => 'required|max:255',
            'image' => 'required',
        ]);

        $slider = new Slider;

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/sliders/' . $filename);
            Image::make($image)->resize(770, 376)->save($location);
            $slider->image = $filename;
        }

        $slider->title = $request->get('title');
        $slider->link = $request->get('link');

        if ($request->get('active') == null) {
            $slider->active = '0';
        } else {
            $slider->active = '1';
        }

        $slider->save();

        // Clear cache
        Cache::flush();

        // Redirect to slider edit page
        return redirect()->route('sliders.edit', $slider->id)->with('success', __('admin.data_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve slider details
        $slider = Slider::find($id);

        // Return 404 page if slider not found
        if ($slider == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::sliders.edit', compact('slider', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'link' => 'required|max:255',
        ]);

        // Retrieve slider details
        $slider = Slider::find($id);

        $slider->title = $request->get('title');
        $slider->link = $request->get('link');

        if ($request->get('active') == null) {
            $slider->active = '0';
        } else {
            $slider->active = '1';
        }

        // Check if the picture has been changed
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/sliders/' . $filename);
            Image::make($image)->resize(770, 376)->save($location);
            $oldfilename = $slider->image;
            $slider->image = $filename;
            File::delete('images/sliders/' . $oldfilename); // Remove old image file
        }

        $slider->save();

        // Clear cache
        Cache::flush();

        // Redirect to slider edit page
        return redirect()->route('sliders.edit', $slider->id)->with('success', __('admin.data_updated'));
    }

    /** Status */
    public function status($id)
    {
        $status = request()->query('status');

        $slider = Slider::find($id);

        if ($status === '0' or $status === '1') {
            $slider->update(['active' => $status]);
        }

        // Clear cache
        Cache::flush();

        // Return view
        return redirect()->route('sliders.index')->with('success', __('admin.data_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve slider details
        $slider = Slider::find($id);

        if (!empty($slider->image)) {
            if (file_exists(public_path() . '/images/sliders/' . $slider->image)) {
                unlink(public_path() . '/images/sliders/' . $slider->image);
            }
        }

        $slider->delete();

        // Clear cache
        Cache::flush();

        // Redirect to list of sliders
        return redirect()->route('sliders.index')->with('success', __('admin.data_deleted'));
    }

}
