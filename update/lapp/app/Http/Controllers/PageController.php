<?php
namespace App\Http\Controllers;

use App;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting
                    ->name] = $setting->value;
        }

        $this->ping_google = $settings['ping_google'];
        $this->page_base = $settings['page_base'];

        // Pass data to views
        View::share(['settings' => $settings]);
    }

    /** Index */
    public function index()
    {
        // List of pages
        $pages = Page::orderBy('sort', 'ASC')->get();

        // Return view
        return view('adminlte::pages.index', compact('pages'));
    }

    /** Order */
    public function order()
    {
        // List of pages
        $posts = Page::orderBy('sort', 'ASC')->get();

        $id = Input::get('id');
        $sorting = Input::get('sort');

        // Update sort order
        foreach ($posts as $item) {
            Page::where('id', '=', $id)->update(array(
                'sort' => $sorting,
            ));
        }

        // Clear cache
        Cache::flush();
    }

    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::pages.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|max:255', 'details' => 'required']);

        $page = new Page;
        $page->title = $request->get('title');
        $page->details = $request->get('details');

        // Retrieve last item in sort order and add +1
        $page->sort = Page::max('sort') + 1;

        $page->slug = null;
        $page->save();
        $page->update(['title' => $page->title]);

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->page_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('pages.edit', $page->id)
            ->with('success', __('admin.data_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve page details
        $page = Page::find($id);

        // Return 404 page if page not found
        if ($page == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::pages.edit', compact('page', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['title' => 'required|max:255', 'details' => 'required']);

        // Retrieve page details
        $page = Page::find($id);
        $page->title = $request->get('title');
        $page->details = $request->get('details');

        // Ping Google
        if ($page->isDirty() && $this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->page_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        $page->slug = null;
        $page->save();
        $page->update(['title' => $page->title]);

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()
            ->route('pages.edit', $page->id)
            ->with('success', __('admin.data_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve page details
        $page = Page::find($id);

        $page->delete();

        // Clear cache
        Cache::flush();

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->page_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Redirect to list of pages
        return redirect()
            ->route('pages.index')
            ->with('success', __('admin.data_deleted'));
    }

}
