<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Raulr\GooglePlayScraper\Scraper;

class CrawlerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // List of categories
        $categories = DB::table('categories')->orderBy('sort', 'ASC')->get();

        // List of crawler categories
        $crawler_categories = DB::table('settings')->where('name', 'crawler_categories')->first();

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        $this->google_play_default_country = $settings['google_play_default_country'];
        $this->google_play_default_language = $settings['google_play_default_language'];

        // Pass data to views
        View::share(['categories' => $categories, 'crawler_categories' => $crawler_categories->value]);
    }

    /** Index */
    public function index()
    {

        // Retrieve categories from Google Play Store
        $scraper = new Scraper();
        $app_categories = $scraper->getCategories($this->google_play_default_language, $this->google_play_default_country);

        // Return view
        return view('adminlte::settings.app_crawler', compact('app_categories'));
    }

    /** Update */
    public function update(Request $request)
    {
        $items = array();
        foreach ($request->except(array('_token', '_method')) as $key => $value) {
            $items[$key] = $value;
        }

        $json = json_encode($items);
        DB::update("update settings set value = '$json' WHERE name = 'crawler_categories'");

        // Clear cache
        Cache::flush();

        // Redirect to settings page
        return redirect('admin/scraper_categories')->with('success', __('admin.data_updated'));
    }

    /** Clear Cache */
    public function clear_cache()
    {
        // Clear cache
        Cache::flush();

        // Redirect to list of applications
        return redirect('admin/apps')->with('success', __('admin.system_cache_cleared'));
    }

}
