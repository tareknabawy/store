<?php

namespace App\Http\Controllers;

use App;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class FrontendSubmissionController extends Controller
{

    public function __construct()
    {

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        $this->cloudflare_ip = $settings['cloudflare_ip'];

    }

    /** Store */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'platform' => 'required',
            'developer' => 'required',
            'url' => 'required',
            'image' =>
            'required
                      |image
                      |mimes:jpeg,png,jpg,gif,svg
                      |max:500',
        ]);

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/submissions/' . $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $file_name = $filename;
        }

        $detailed_desc = request()->detailed_description;
        $detailed_desc = nl2br($detailed_desc);

        if ($this->cloudflare_ip == '1') {
            $client_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $client_ip = $request->ip();
        }

        DB::table('submissions')->insert(
            [
                'name' => request()->name,
                'email' => request()->email,
                'title' => request()->title,
                'description' => request()->description,
                'category' => request()->category,
                'platform' => request()->platform,
                'developer' => request()->developer,
                'url' => request()->url,
                'license' => request()->license,
                'file_size' => request()->file_size,
                'image' => $file_name,
                'details' => $detailed_desc,
                'ip' => $client_ip,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return '<div class="alert alert-success mt-3 show" role="alert">' . __('general.submission_thanks') . '</div>';
    }

}
