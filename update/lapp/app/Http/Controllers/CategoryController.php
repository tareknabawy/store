<?php
namespace App\Http\Controllers;

use App;
use App\Application;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // List of categories
        $categories = Category::orderBy('sort', 'ASC')->get();

        // List of icons
        $icons = DB::table('fa_icons')->orderBy('title', 'asc')
            ->get();

        // Schema.org Application Categories
        $applicationcategories = array(
            '0' => "None",
            '1' => "GameApplication",
            '2' => 'SocialNetworkingApplication',
            '3' => 'TravelApplication',
            "4" => 'ShoppingApplication',
            "5" => 'SportsApplication',
            "6" => 'LifestyleApplication',
            "7" => 'BusinessApplication',
            "8" => 'DesignApplication',
            "9" => 'DeveloperApplication',
            "10" => 'DriverApplication',
            "11" => 'EducationalApplication',
            "12" => 'HealthApplication',
            "13" => 'FinanceApplication',
            "14" => 'SecurityApplication',
            "15" => 'BrowserApplication',
            "16" => 'CommunicationApplication',
            "17" => 'DesktopEnhancementApplication',
            "18" => 'EntertainmentApplication',
            "19" => 'MultimediaApplication',
            "20" => 'HomeApplication',
            "21" => 'UtilitiesApplication',
            "22" => 'ReferenceApplication',
        );

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting
                    ->name] = $setting->value;
        }

        $this->ping_google = $settings['ping_google'];
        $this->category_base = $settings['category_base'];

        // Pass data to views
        View::share(['categories' => $categories, 'icons' => $icons, 'applicationcategories' => $applicationcategories, 'settings' => $settings]);
    }

    /** Index */
    public function index()
    {
        // Return view
        return view('adminlte::categories.index');
    }

    /** Order */
    public function order()
    {
        // List of categories
        $posts = Category::orderBy('sort', 'ASC')->get();

        $id = Input::get('id');
        $sorting = Input::get('sort');

        // Update sort order
        foreach ($posts as $item) {
            Category::where('id', '=', $id)->update(array(
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
        return view('adminlte::categories.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|max:255']);

        $category = new Category;
        $category->title = $request->get('title');
        $category->description = $request->get('description');
        $category->fa_icon = $request->get('fa_icon');
        $category->application_category = $request->get('application_category');
        $category->navbar = $request->get('navbar');
        $category->footer = $request->get('footer');

        $category->slug = null;

        if ($request->get('navbar') == null) {
            $category->navbar = 0;
        } else {
            $category->navbar = 1;
        }

        if ($request->get('footer') == null) {
            $category->footer = 0;
        } else {
            $category->footer = 1;
        }

        // Retrieve last item in sort order and add +1
        $category->sort = Category::max('sort') + 1;

        $category->save();
        $category->update(['title' => $category->title]);

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->category_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Clear cache
        Cache::flush();

        // Redirect to category edit page
        return redirect()->route('categories.edit', $category->id)
            ->with('success', __('admin.data_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve category details
        $category = Category::find($id);

        // Return 404 page if category not found
        if ($category == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::categories.edit', compact('category', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['title' => 'required|max:255']);

        // Retrieve category details
        $category = Category::find($id);

        $category->title = $request->get('title');
        $category->description = $request->get('description');
        $category->fa_icon = $request->get('fa_icon');
        $category->application_category = $request->get('application_category');
        $category->navbar = $request->get('navbar');
        $category->footer = $request->get('footer');

        if ($request->get('navbar') == null) {
            $category->navbar = '0';
        } else {
            $category->navbar = '1';
        }

        if ($request->get('footer') == null) {
            $category->footer = '0';
        } else {
            $category->footer = '1';
        }

        // Ping Google
        if ($category->isDirty() && $this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->category_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        $category->slug = null;

        $category->save();
        $category->update(['title' => $category->title]);

        // Clear cache
        Cache::flush();

        // Redirect to category edit page
        return redirect()
            ->route('categories.edit', $category->id)
            ->with('success', __('admin.data_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {

        // Check if apps exist under this category
        $check_apps = Application::where('category', "$id")->count();

        if ($check_apps >= '1') {
            return redirect()->route('categories.index')
                ->with('error', __('admin.category_platform_delete_error'));
        }

        // Retrieve category details
        $category = Category::find($id);

        $category->delete();

        // Clear cache
        Cache::flush();
        
        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->category_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Redirect to list of categories
        return redirect()
            ->route('categories.index')
            ->with('success', __('admin.data_deleted'));
    }

}
