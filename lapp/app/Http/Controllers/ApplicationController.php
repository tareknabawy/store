<?php

namespace App\Http\Controllers;

use App;
use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Redirect;
use Storage;

class ApplicationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // CPU usage
        if (function_exists('shell_exec')) {
            $str = substr(strrchr(shell_exec("uptime"), ":"), 1);
            $avs = array_map("trim", explode(",", $str));
            $sload = $avs[0];
        } else {
            $sload = '0';
        }

        // List of categories
        $categories = DB::table('categories')->orderBy('sort', 'ASC')->get();

        // List of Platforms
        $platforms = DB::table('platforms')->orderBy('sort', 'ASC')->get();

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        // Count of applications
        if ($settings['enable_cache'] == '1') {
            $total_apps = Cache::rememberForever('total-apps', function () {
                Cache::increment('total_cached');
                return DB::table('applications')->count('id');
            });
        } else {
            $total_apps = DB::table('applications')->count('id');
        }

        // Count of total downloads
        if ($settings['enable_cache'] == '1') {
            $total_downloads = Cache::rememberForever('total-downloads', function () {
                Cache::increment('total_cached');
                return DB::table('applications')->sum('counter');
            });
        } else {
            $total_downloads = DB::table('applications')->sum('counter');
        }

        $this->ping_google = $settings['ping_google'];
        $this->app_base = $settings['app_base'];

        // Pass data to views
        View::share(['platforms' => $platforms, 'categories' => $categories, 'total_apps' => $total_apps, 'total_downloads' => $total_downloads, 'sload' => $sload, 'settings' => $settings]);
    }

    /** Search */
    public function search()
    {
        $searchquery = request()->post('term');

        // Return 403 page if query is empty
        if ($searchquery == null) {
            abort(403);
        }

        // Retrieve search result
        $apps = Application::orderBy('id', 'desc')->where('title', 'like', "%{$searchquery}%")->paginate(15);

        // Return view
        return view('adminlte::apps.search', compact('apps'));
    }

    /** Index */
    public function index(Request $request)
    {
        // List of latest applications
        $apps = Application::join('categories', 'applications.category', '=', 'categories.id')->where(function($q){
            if(request()->get('owner_id')!=null)
                $q->where('owner_id',request()->get('owner_id'));
        })
            ->join('platforms', 'applications.platform', '=', 'platforms.id')
            ->select('applications.*', 'categories.title AS category_title', 'platforms.title AS platform_title')
            ->orderBy('id', 'desc')->paginate(15);

        // Return view
        return view('adminlte::apps.index', compact('apps'));
    }

    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::apps.create');
    }

    /** Store */
    public function store(Request $request)
    {

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

        $slug_check = Application::where('slug', $request->get('slug'))->first();

        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $app->image = $filename;
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
        $app->screenshots = '';

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

        
        $app->save();
        $tags = explode(",", $request->get('tags'));
        $app->tag($tags);
        foreach($app->tags as $tag){
            \App\TaggingTag::where('id',$tag->id)->whereNull('created_at')->whereNull('updated_at')->update(['created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]); 
        }


        

        if ($request->get('slug') == null) {
            $app->slug = null;
            $app->update(['title' => $app->title]);
        }

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->app_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Clear cache
        Cache::flush();

        // Redirect to application edit page
        return redirect()->route('apps.edit', $app->id)->with('success', __('admin.data_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve application details
        $app = Application::find($id);

        // Return 404 page if application not found
        if ($app == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::apps.edit', compact('app', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
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

        $slug_check = Application::where('slug', $request->get('slug'))->where('id', '!=', $id)->first();

        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        // Retrieve application details
        $app = Application::find($id);

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
        $app->platform = $request->get('platform');
        $app->details = $request->get('details');
        $app->type = $request->get('type');
        $app->untag();

        $tags = explode(",", $request->get('tags'));
        $app->tag($tags);
        
        foreach($app->tags as $tag){
            \App\TaggingTag::where('id',$tag->id)->whereNull('created_at')->whereNull('updated_at')->update(['created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]); 
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

        // Check if the file has been uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $original_name = $file->getClientOriginalName();
            $request->file->move(public_path('/files'), $original_name);
            $app->url = asset('/files') . '/' . $original_name;
        }

        // Check if the picture has been changed
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $oldfilename = $app->image;
            $app->image = $filename;
            Storage::delete($oldfilename); // Remove old image file
        }

        // Ping Google
        if ($app->isDirty() && $this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->app_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        if ($request->get('slug') == null) {
            $app->slug = null;
            $app->update(['title' => $app->title]);
        }

        $app->save();

        // Clear cache
        Cache::flush();

        // Redirect to application edit page
        return redirect()->route('apps.edit', $app->id)->with('success', __('admin.data_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve application details
        $app = Application::find($id);

        if (!empty($app->image)) {
            if (file_exists(public_path() . '/images/' . $app->image)) {
                unlink(public_path() . '/images/' . $app->image);
            }
        }

        $app->delete();

        // Clear cache
        Cache::flush();

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->app_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Redirect to list of applications
        return redirect()->route('apps.index')->with('success', __('admin.data_deleted'));
    }

}
