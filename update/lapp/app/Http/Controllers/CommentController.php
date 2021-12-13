<?php

namespace App\Http\Controllers;

use App;
use App\Comment;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        // Pass data to views
        View::share(['settings' => $settings]);
    }

    /** Index */
    public function index()
    {
        // List of comments
        $comments = Comment::join('applications', 'comments.app_id', '=', 'applications.id')
            ->select('comments.*', 'applications.title as app_title', 'applications.slug as app_slug')
            ->orderBy('id', 'desc')->paginate(15);

        // Return view
        return view('adminlte::comments.index', compact('comments'));
    }

    /** Edit */
    public function edit($id)
    {

        $status = Input::get("approve");

        $comment = Comment::find($id);
        $user_rating = $comment->rating;
        $app_id = $comment->app_id;

        if ($status === '0' or $status === '1') {
            $comment->update(['approval' => $status]);
        }

        if ($status === '1') {

            // Get average rating
            $rating_query = DB::table('applications')->where('id', $app_id)->first();
            $votes = $rating_query->votes;

            $total_votes = $rating_query->total_votes;

            $new_average = ($votes * $total_votes + $user_rating) / ($total_votes + 1);

            // Update total votes and votes count
            DB::table('applications')->where('id', $app_id)->update(array('votes' => $new_average));
            DB::table('applications')->where('id', $app_id)->increment('total_votes');
        }

        if ($status === '0') {

            // Get average rating
            $rating_query = DB::table('applications')->where('id', $app_id)->first();
            $votes = $rating_query->votes;

            $total_votes = $rating_query->total_votes;

            if ($total_votes == '1') {
                $new_average = '0';
            } else {
                $new_average = ((($votes * $total_votes) - $user_rating) / ($total_votes - 1));
            }

            // Update total votes and votes count
            DB::table('applications')->where('id', $app_id)->update(array('votes' => $new_average));
            DB::table('applications')->where('id', $app_id)->decrement('total_votes');
        }

        // Clear cache
        Cache::flush();

        // Return view
        return redirect()->route('comments.index')->with('success', __('admin.data_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve comment details
        $comment = Comment::find($id);
        $user_rating = $comment->rating;
        $app_id = $comment->app_id;
        $comment_status = $comment->approval;

        if ($comment_status == '1') {

            // Get average rating
            $rating_query = DB::table('applications')->where('id', $app_id)->first();
            $votes = $rating_query->votes;

            $total_votes = $rating_query->total_votes;

            if ($total_votes == '1') {
                $new_average = '0';
            } else {
                $new_average = ((($votes * $total_votes) - $user_rating) / ($total_votes - 1));
            }

            // Update total votes and votes count
            DB::table('applications')->where('id', $app_id)->update(array('votes' => $new_average));
            DB::table('applications')->where('id', $app_id)->decrement('total_votes');
        }

        $comment->delete();

        // Clear cache
        Cache::flush();

        // Redirect to list of comments
        return redirect()->route('comments.index')->with('success', __('admin.data_deleted'));
    }
}
