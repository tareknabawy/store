<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MultipleUploadController extends Controller
{

    /** Index */
    public function index()
    {
        $this->middleware('auth');

        return view('adminlte::multiple_file_upload');
    }

    /** Delete */
    public function delete(Request $request)
    {

        if (!empty($request->image_name)) {
            if (file_exists(public_path() . '/screenshots/' . $request->image_name)) {
                unlink(public_path() . '/screenshots/' . $request->image_name);
            }
        }

        $screenshot_query = DB::table('applications')->where('id', '=', $request->app_id)->pluck('screenshots');

        $screenshot_query = explode(',', $screenshot_query[0]);

        $screenshots = array_diff($screenshot_query, array($request->image_name));

        $comma_separated = implode(",", $screenshots);
        DB::table('applications')->where('id', $request->app_id)->update(array('screenshots' => $comma_separated));

        // Clear cache
        Cache::flush();
    }

    /** Upload */
    public function upload(Request $request)
    {

        $this->validate($request, [
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image_code = '';
        $images = $request->file('file');
        foreach ($images as $image) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('screenshots'), $new_name);
            $image_code .= "$new_name,";
            $sql_query = "UPDATE applications set screenshots = IF(`screenshots` = '','$new_name',CONCAT(screenshots, ',', '$new_name')) WHERE find_in_set('$new_name',screenshots) = 0 AND id = $request->app_id";
            $result = DB::update($sql_query);
        }

        $screenshot_query = DB::table('applications')->where('id', '=', $request->app_id)->pluck('screenshots');

        $mysplit = explode(',', $screenshot_query[0]);
        $screenshot_data = array_reverse($mysplit);

        $image_code_s = '';
        foreach ($screenshot_data as $screenshot) {
            $image_code_s .= '<div class="col-md-2 mb-10 text-center"><img src="/screenshots/' . $screenshot . '" class="img-thumbnail" /><button type="button" data-name="' . $screenshot . '" data-app-id="' . $request->app_id . '" class="btn btn-danger mt-10 remove_screenshot">Delete</button></div>';
        }

        $output = array(
            'success' => __('admin.images_uploaded'),
            'image' => $image_code_s,
        );

        // Clear cache
        Cache::flush();

        return response()->json($output);
    }

}
