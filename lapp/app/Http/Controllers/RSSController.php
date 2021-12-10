<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RssController extends Controller
{

    /** Index */
    public function index()
    {

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        // List of applications
        $apps = Cache::rememberForever("rss-apps", function () {
            Cache::increment('total_cached');
            return Application::orderBy('id', 'desc')->limit(10)->get();

        });

        // Return view
        return response()->view('frontend::rss', ['apps' => $apps, 'settings' => $settings])->header('Content-Type', 'application/xml');

    }

}
