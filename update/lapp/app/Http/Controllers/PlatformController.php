<?php
namespace App\Http\Controllers;

use App;
use App\Application;
use App\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Storage;

class PlatformController extends Controller
{

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->middleware('auth');

        // List of platforms
        $platforms = Platform::orderBy('sort', 'ASC')->get();

        // List of icons
        $icons = DB::table('fa_icons')->orderBy('title', 'asc')
            ->get();

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting
                    ->name] = $setting->value;
        }

        $this->ping_google = $settings['ping_google'];
        $this->platform_base = $settings['platform_base'];

        // Pass data to views
        View::share(['platforms' => $platforms, 'icons' => $icons, 'settings' => $settings]);
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        // Return view
        return view('adminlte::platforms.index');
    }

    /**  Change order of resources. */
    public function order()
    {
        // List of platforms
        $posts = Platform::orderBy('sort', 'ASC')->get();

        $id = Input::get('id');
        $sorting = Input::get('sort');

        // Update sort order
        foreach ($posts as $item) {
            Platform::where('id', '=', $id)->update(array(
                'sort' => $sorting,
            ));
        }

        // Clear cache
        Cache::flush();
    }

    /**  Show the form for creating a new resource. */
    public function create()
    {
        // Return view
        return view('adminlte::platforms.create');
    }

    /**  Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|max:255', 'fa_icon' => 'required']);

        $platform = new Platform;
        $platform->title = $request->get('title');
        $platform->fa_icon = $request->get('fa_icon');
        $platform->slug = null;

        // Retrieve last item in sort order and add +1
        $platform->sort = Platform::max('sort') + 1;

        $platform->save();
        $platform->update(['title' => $platform->title]);

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->platform_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Clear cache
        Cache::flush();

        // Redirect to platform edit page
        return redirect()->route('platforms.edit', $platform->id)
            ->with('success', __('admin.data_added'));
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve platform details
        $platform = Platform::find($id);

        // Return 404 page if platform not found
        if ($platform == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::platforms.edit', compact('platform', 'id'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['title' => 'required|max:255', 'fa_icon' => 'required']);

        // Retrieve platform details
        $platform = Platform::find($id);

        $platform->title = $request->get('title');
        $platform->fa_icon = $request->get('fa_icon');

        // Ping Google
        if ($platform->isDirty() && $this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->platform_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        $platform->slug = null;
        $platform->save();
        $platform->update(['title' => $platform->title]);

        // Clear cache
        Cache::flush();

        // Redirect to platform edit page
        return redirect()
            ->route('platforms.edit', $platform->id)
            ->with('success', __('admin.data_updated'));
    }

    /** Remove the specified resource from storage. */
    public function destroy($id)
    {
        // Check if apps exist under this platform
        $check_apps = Application::where('platform', "$id")->count();

        if ($check_apps >= '1') {
            return redirect()->route('platforms.index')
                ->with('error', __('admin.category_platform_delete_error'));
        }

        // Retrieve platform details
        $platform = Platform::find($id);

        $platform->delete();

        // Clear cache
        Cache::flush();

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->platform_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Redirect to list of platforms
        return redirect()
            ->route('platforms.index')
            ->with('success', __('admin.data_deleted'));
    }

}
