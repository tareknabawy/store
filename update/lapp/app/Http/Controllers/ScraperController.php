<?php
namespace App\Http\Controllers;

use App;
use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Raulr\GooglePlayScraper\Scraper;
use Redirect;

class ScraperController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // List of categories
        $categories = DB::table('categories')->orderBy('sort', 'ASC')
            ->get();

        // List of Platforms
        $platforms = DB::table('platforms')->orderBy('sort', 'ASC')
            ->get();

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting
                    ->name] = $setting->value;
        }

        $this->google_play_default_country = $settings['google_play_default_country'];
        $this->google_play_default_language = $settings['google_play_default_language'];
        $this->crawler_categories = $settings['crawler_categories'];
        $this->screenshot_count = $settings['screenshot_count'];

        // Pass data to views
        View::share(['platforms' => $platforms, 'categories' => $categories, 'settings' => $settings]);
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        $searchquery = request()->post('term');

        if ($searchquery == null) {
            // If search term is null than use "free" as search term
            return redirect('admin/scraper?term=free');
        } else {
            $scraper = new Scraper();
            $searchquery = request()->post('term');

            // Retrieve search results from Google Play Store
            $apps = $scraper->getSearch($searchquery, 'all', 'all', $this->google_play_default_language, $this->google_play_default_country);

            // Return view
            return view('adminlte::scraper.index', compact('apps'));
        }
    }

    /** Show */
    public function show($id)
    {
        // Get app details from Google Play Store
        $scraper = new Scraper();
        $app = $scraper->getApp($id, $this->google_play_default_language, $this->google_play_default_country);

        // Unfortunately, publishers do not use a standard format for description, so we need to format it
        // Explode description into two pieces, first paragraph for description and rest of it for detailed description
        $first_p = explode("<br>", $app['description_html'], 2);

        // Set first paragraph as description
        $description = strip_tags($first_p[0]);

        // If description length longer than 150 chars explode with dot
        if (strlen($first_p[0]) >= 150) {
            $first_p = explode(". ", $app['description_html'], 2);
            $description = strip_tags($first_p[0]) . '.';
        }

        // If not empty use second part as detailed description
        if (isset($first_p[1])) {
            $detailed_description = $first_p[1];
        } else {
            $detailed_description = null;
        }

        $crawler_categories = json_decode($this->crawler_categories);
        foreach ($crawler_categories as $value => $key) {
            if ($app['categories'][0] == $value) {
                $item_category = $key;
            }
        }

        // Remove if first line of detailed description contains <br>
        $detailed_description = @preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $detailed_description);

        // Return view
        return view('adminlte::scraper.create', compact('app'))->with('description', $description)->with('detailed_description', $detailed_description)->with('item_category', $item_category);
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

            // Download image from Google Play Store to temp folder
            Image::make($path)->save(public_path('images/temp/' . $filename));
            $tempimage = "images/temp/$filename";
            $location = "images/$filename";

            Image::make($tempimage)->resize(200, 200)
                ->save($location); // Resize image
            $app->image = $filename;

            unlink($tempimage); // Unlink temp image
        }

        $max_screenshots = $this->screenshot_count;

        $screenshots = $request->get('screenshots');

        if ($max_screenshots != '0') {

            $explode_screenshots = explode(",", $screenshots);
            $total_screenshots = count($explode_screenshots);

            if ($total_screenshots >= $max_screenshots) {
                $total_screenshots = $max_screenshots;
            }

            $ss_array = array();

            for ($x = 0; $x <= $total_screenshots - 1; $x++) {

                $ss_filename = rand(111111111, 999999999999) . '.jpg';

                // Download screenshots from Google Play Store to temp folder
                Image::make($explode_screenshots[$x])->save(public_path('screenshots/temp/' . $ss_filename));
                $ss_tempimage = "screenshots/temp/$ss_filename";
                $ss_location = "screenshots/$ss_filename";

                Image::make($ss_tempimage)->save($ss_location); // Save image
                unlink($ss_tempimage); // Unlink temp image
                array_push($ss_array, $ss_filename);

            }

            $screenshots_list = implode(',', $ss_array);

        } else {
            $screenshots_list = '';
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
        $app->screenshots = $screenshots_list;
        $app->type = $request->get('type');

        $app->save();

        $tags = explode(",", $request->get('tags'));
        $app->tag($tags);

        if ($request->get('slug') == null) {
            $app->slug = null;
            $app->update(['title' => $app->title]);
        }

        // Clear cache
        Cache::flush();

        // Redirect to application edit page
        return redirect()
            ->route('apps.edit', $app->id)
            ->with('success', __('admin.data_added'));
    }

}
