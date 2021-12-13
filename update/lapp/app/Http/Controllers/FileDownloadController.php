<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Cache;

class FileDownloadController extends Controller
{

    public function __construct()
    {
        //
    }

    /** Show */
    public function show()
    {
        // Retrieve application details
        $download_query = Cache::rememberForever("download-query-" . request()->id . "", function () {
            Cache::increment('total_cached');
            return DB::table('applications')->where('id', request()->id)->first();
        });

        // Return 404 page if application not found
        if ($download_query == null) {
            abort(404);
        }

        // Update download count
        DB::table('applications')->where('id', request()->id)->increment('counter');

        // Redirect to file or page
        return redirect()->away($download_query->url);
    }

}
