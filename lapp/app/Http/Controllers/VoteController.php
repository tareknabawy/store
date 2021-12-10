<?php

namespace App\Http\Controllers;

use App;
use DB;
use Illuminate\Http\Request;

class VoteController extends Controller
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

    /** Show */
    public function show(Request $request)
    {
        $vote = request()->vote;

        // Get user IP address
        if ($this->cloudflare_ip == '1') {
            $client_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $client_ip = $request->ip();
        }

        // Check if user voted for this aplication
        $vote_query = DB::table('votes')->where([['ip', '=', $client_ip], ['pid', '=', request()->id]])->get();

        if (count($vote_query) === 0) {
            DB::table('votes')->insert(['ip' => $client_ip, 'pid' => request()->id]);

            // Get average rating
            $rating_query = DB::table('applications')->where('id', request()->id)->first();

            $votes = $rating_query->votes;
            $total_votes = $rating_query->total_votes;

            $new_average = ($votes * $total_votes + $vote) / ($total_votes + 1);

            // Update total votes and votes count
            DB::table('applications')->where('id', request()->id)->update(array('votes' => $new_average));
            DB::table('applications')->where('id', request()->id)->increment('total_votes');

            // Return result
            return '<div class="alert alert-success" role="alert">' . __('general.voted') . '</div>';
        } else {
            return '<div class="alert alert-warning" role="alert">' . __('general.already_voted') . '</div>';
        }
    }

}
