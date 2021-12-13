<?php

namespace App\Http\Controllers;

use App;
use App\Application;
use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

class SubmissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // List of categories
        $categories = DB::table('categories')->orderBy('sort', 'ASC')->get();

        // List of Platforms
        $platforms = DB::table('platforms')->orderBy('sort', 'ASC')->get();

        // Pass data to views
        View::share(['platforms' => $platforms, 'categories' => $categories]);
    }

    /** Index */
    public function index()
    {
        // List of latest submissions
        $submissions = Submission::orderBy('id', 'desc')->paginate(10);

        // Return view
        return view('adminlte::submissions.index', compact('submissions'));
    }

    /** Show */
    public function show($id)
    {
        // Retrieve submission details
        $submission = Submission::find($id);

        // Return 404 page if submission not found
        if ($submission == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::submissions.create', compact('submission', 'id'));
    }

    /** Store */
    public function store(Request $request)
    {

        $slug_check = Application::where('slug', $request->get('slug'))->first();

        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $app = new Application;

        // Check if the file has been uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $original_name = $file->getClientOriginalName();
            $request->file->move(public_path('/files'), $original_name);
            $app->url = asset('/files') . '/' . $original_name;
            $request->merge([
                'url' => $app->url,
            ]);
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:755',
            'category' => 'required',
            'platform' => 'required',
            'developer' => 'required',
            'counter' => 'required',
            'url' => 'required',
            'type' => 'required',
        ]);

        $submission_id = $request->get('app_id');

        // Check if the picture has been uploaded
        if ($request->hasFile('different_image')) {
            $image = $request->file('different_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $app->image = $filename;

        } else {

            $image = $request->get('image');
            $path = $image;
            $filename = rand(1111111, 9999199) . '.png';

            // Move image from submission folder
            $temp_image = public_path('images/submissions/' . $image);
            $location = public_path('images/' . $filename);

            Image::make($temp_image)->resize(200, 200)
                ->save($location); // Resize image
            $app->image = $filename;

            unlink($temp_image); // Unlink submission image
        }

        if (is_null($app['price'])) {
            $app_price = __('admin.free');
        } else {
            $app_price = $app['price'];
        }

        if ($request->get('featured') == null) {
            $app->featured = '0';
        } else {
            $app->featured = '1';
        }

        if ($request->get('pinned') == null) {
            $app->pinned = '0';
        } else {
            $app->pinned = '1';
        }

        if ($request->get('editors_choice') == null) {
            $app->editors_choice = '0';
        } else {
            $app->editors_choice = '1';
        }

        if ($request->get('must_have') == null) {
            $app->must_have = '0';
        } else {
            $app->must_have = '1';
        }

        $app->slug = $request->get('slug');
        $app->title = $request->get('title');
        $app->description = $request->get('description');
        $app->custom_description = $request->get('custom_description');
        $app->counter = $request->get('counter');
        $app->category = $request->get('category');
        $app->file_size = $request->get('file_size');
        $app->url = $request->get('url');
        $app->buy_url = $request->get('buy_url');
        $app->license = $request->get('license');
        $app->developer = $request->get('developer');
        $app->details = $request->get('details');
        $app->platform = $request->get('platform');
        $app->type = $request->get('type');
        $app->owner_id = $request->get('owner_id');
        $app->screenshots = '';

        $app->save();

        $tags = explode(",", $request->get('tags'));
        $app->tag($tags);

        if ($request->get('slug') == null) {
            $app->slug = null;
            $app->update(['title' => $app->title]);
        }

        DB::table('submissions')->delete($submission_id);

        // Clear cache
        Cache::flush();

        // Redirect to application edit page
        return redirect()->route('submissions.index')->with('success', __('admin.data_added'));
    }

    /** Destory */
    public function destroy($id)
    {
        // Retrieve submission details
        $submission = Submission::find($id);

        if (!empty($submission->image)) {
            if (file_exists(public_path() . '/images/submissions/' . $submission->image)) {
                unlink(public_path() . '/images/submissions/' . $submission->image);
            }
        }

        $submission->delete();

        // Redirect to list of submissions
        return redirect()->route('submissions.index')->with('success', __('admin.data_deleted'));
    }

}