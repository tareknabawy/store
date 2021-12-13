<?php

namespace App\Http\Controllers;

use App;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FrontendCommentController extends Controller
{

    public function __construct()
    {

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        $this->auto_comment_approval = $settings['auto_comment_approval'];
        $this->enable_cache = $settings['enable_cache'];
        $this->cloudflare_ip = $settings['cloudflare_ip'];

    }

    /** Show */
    public function store(Request $request)
    {

        $this->validate($request, [
            'app_id' => 'required',
            'name' => 'required',
            'title' => 'required',
            'email' => 'required',
            'comment' => 'required',
            'user_rating' => 'required',
        ]);

        if ($this->auto_comment_approval == '1') {
            $approval = '1';

            if ($this->enable_cache == '1') {
                
                // Clear cache
                Cache::flush();
            }

        } else {
            $approval = '0';
        }

        if ($this->cloudflare_ip == '1') {
            $client_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $client_ip = $request->ip();
        }

        DB::table('comments')->insert(
            [
                'app_id' => request()->app_id,
                'name' => request()->name,
                'title' => request()->title,
                'email' => request()->email,
                'comment' => request()->comment,
                'rating' => request()->user_rating,
                'approval' => $approval,
                'ip' => $client_ip,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return '<div class="alert alert-success mt-3 show" role="alert">' . __('general.comment_thanks') . '</div>';
    }

}
