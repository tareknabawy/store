<?php

namespace App\Http\Controllers;

use App;
use App\Application;
use App\Category;
use App\Topic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use MetaTag;
use Spatie\SchemaOrg\Schema;

class SiteController extends Controller
{

    public function __construct()
    {

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        $this->site_title = $settings['site_title'];
        $this->site_description = $settings['site_description'];
        $this->twitter_account = $settings['twitter_account'];
        $this->schema_org_price_currency = $settings['schema_org_price_currency'];
        $this->show_submission_form = $settings['show_submission_form'];
        $this->use_text_logo = $settings['use_text_logo'];
        $this->app_base = $settings['app_base'];
        $this->news_base = $settings['news_base'];
        $this->topic_base = $settings['topic_base'];
        $this->tag_base = $settings['tag_base'];
        $this->category_base = $settings['category_base'];
        $this->platform_base = $settings['platform_base'];
        $this->enable_cache = $settings['enable_cache'];
        $this->reading_time = $settings['reading_time'];

        // Open Graph locale tags
        if ($this->enable_cache == '1') {
            $locale_tags = Cache::rememberForever('locale-tags', function () {
                Cache::increment('total_cached');
                return DB::table('translations')->get()->pluck('locale_code', 'code');
            });
        } else {
            $locale_tags = DB::table('translations')->get()->pluck('locale_code', 'code');
        }

        $locale_tags = $locale_tags->toArray();

        // Ad Places
        if ($this->enable_cache == '1') {
            $ad_places = Cache::rememberForever('ad-places', function () {
                Cache::increment('total_cached');
                return DB::table('ads')->get();
            });
        } else {
            $ad_places = DB::table('ads')->get();
        }

        foreach ($ad_places as $ads) {
            $ad[$ads->id] = $ads->code;
        }

        // List of Categories
        if ($this->enable_cache == '1') {
            $categories = Cache::rememberForever('categories', function () {
                Cache::increment('total_cached');
                return Category::select('id', 'title', 'slug', 'fa_icon', 'application_category', 'navbar', 'footer')->orderBy('sort', 'ASC')->get();
            });
        } else {
            $categories = Category::select('id', 'title', 'slug', 'fa_icon', 'application_category', 'navbar', 'footer')->orderBy('sort', 'ASC')->get();
        }

        // List of Platforms
        if ($this->enable_cache == '1') {
            $platforms = Cache::rememberForever('platforms', function () {
                Cache::increment('total_cached');
                return DB::table('platforms')->select('id', 'title', 'slug')->orderBy('sort', 'ASC')->get();
            });
        } else {
            $platforms = DB::table('platforms')->select('id', 'title', 'slug')->orderBy('sort', 'ASC')->get();
        }

        // List of Popular Apps
        if ($this->enable_cache == '1') {
            $popular_apps = Cache::rememberForever('popular-apps', function () {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'votes', 'category', 'image')->orderBy('counter', 'desc')->limit(10)->get();
            });
        } else {
            $popular_apps = Application::select('title', 'slug', 'votes', 'category', 'image')->orderBy('counter', 'desc')->limit(10)->get();
        }

        // List of Latest News
        if ($this->enable_cache == '1') {
            $latest_news = Cache::rememberForever('last-news', function () {
                Cache::increment('total_cached');
                return DB::table('news')->select('title', 'slug', 'image')->orderBy('id', 'desc')->limit(2)->get();
            });
        } else {
            $latest_news = DB::table('news')->select('title', 'slug', 'image')->orderBy('id', 'desc')->limit(2)->get();
        }

        // List of Pages
        if ($this->enable_cache == '1') {
            $pages = Cache::rememberForever('pages', function () {
                Cache::increment('total_cached');
                return DB::table('pages')->select('title', 'slug')->orderBy('sort', 'ASC')->get();
            });
        } else {
            $pages = DB::table('pages')->select('title', 'slug')->orderBy('sort', 'ASC')->get();
        }

        // List of Editor's Choice Apps
        if ($this->enable_cache == '1') {
            $editors_choice = Cache::rememberForever('editors-choice-apps', function () {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'votes', 'image', 'category')->where('editors_choice', '=', '1')->orderBy('id', 'desc')->limit(10)->get();
            });
        } else {
            $editors_choice = Application::select('title', 'slug', 'votes', 'image', 'category')->where('editors_choice', '=', '1')->orderBy('id', 'desc')->limit(10)->get();
        }

        // Pass data to views
        View::share(['ad' => $ad, 'settings' => $settings, 'platforms' => $platforms, 'popular_apps' => $popular_apps, 'pages' => $pages, 'categories' => $categories, 'latest_news' => $latest_news, 'locale_tags' => $locale_tags, 'editors_choice' => $editors_choice]);
    }

    /** Index */
    public function index()
    {
        // Meta tags
        MetaTag::setTags([
            'title' => $this->site_title,
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => $this->site_title,
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => $this->site_title,
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // List of applications in home page
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever('home-page-apps', function () {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'image', 'license', 'votes', 'created_at')->orderBy('id', 'desc')->limit(12)->get();
            });
        } else {
            $apps = Application::select('title', 'slug', 'image', 'license', 'votes', 'created_at')->orderBy('id', 'desc')->limit(12)->get();
        }

        // List of popular apps in last 24 hours
        if ($this->enable_cache == '1') {
            $apps_24_hours = Cache::rememberForever("popular-apps-24-hours", function () {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'image', 'license', 'votes', 'category')->orderBy('hits', 'desc')->limit(33)->get();
            });
        } else {
            $apps_24_hours = Application::select('title', 'slug', 'image', 'license', 'votes', 'category')->orderBy('hits', 'desc')->limit(33)->get();
        }

        // Must-Have apps in the website
        if ($this->enable_cache == '1') {
            $must_have_apps = Cache::rememberForever('must-have-apps', function () {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'image', 'license', 'votes', 'category')->where('must_have', 1)->orderBy('id', 'desc')->limit(9)->get();
            });
        } else {
            $must_have_apps = Application::select('title', 'slug', 'image', 'license', 'votes', 'category')->where('must_have', 1)->orderBy('id', 'desc')->limit(9)->get();
        }

        // Featured apps in the website
        if ($this->enable_cache == '1') {
            $featured_apps = Cache::rememberForever('featured-apps', function () {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'image')->where('featured', 1)->orderBy('id', 'desc')->limit(10)->get();
            });
        } else {
            $featured_apps = Application::select('title', 'slug', 'image')->where('featured', 1)->orderBy('id', 'desc')->limit(10)->get();
        }

        // List of topics

        if ($this->enable_cache == '1') {
            $all_topics = Cache::rememberForever("topics-home", function () {
                Cache::increment('total_cached');
                return Topic::select('title', 'slug', 'image')->orderBy('id', 'desc')->paginate(5);
            });
        } else {
            $all_topics = Topic::select('title', 'slug', 'image')->orderBy('id', 'desc')->paginate(5);
        }

        // List of sliders in the website
        if ($this->enable_cache == '1') {
            $sliders = Cache::rememberForever('sliders', function () {
                Cache::increment('total_cached');
                return DB::table('sliders')
                    ->leftJoin('applications', 'sliders.link', '=', 'applications.id')
                    ->select('sliders.*', 'applications.slug')
                    ->where('active', 1)
                    ->orderBy('sliders.id', 'desc')
                    ->get();
            });
        } else {
            $sliders = DB::table('sliders')
                ->leftJoin('applications', 'sliders.link', '=', 'applications.id')
                ->select('sliders.*', 'applications.slug')
                ->where('active', 1)
                ->orderBy('sliders.id', 'desc')
                ->get();
        }

        // Return view
        return view('frontend::site')->with('apps', $apps)->with('apps_24_hours', $apps_24_hours)->with('featured_apps', $featured_apps)->with('must_have_apps', $must_have_apps)->with('all_topics', $all_topics)->with('sliders', $sliders);
    }

    /** Categories */
    public function category()
    {
        $slug = request()->slug;

        // Check if category exist
        if ($this->enable_cache == '1') {
            $category_query = Cache::rememberForever("category-query-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return Category::select('id', 'title', 'description')->where('slug', $slug)->first();
            });
        } else {
            $category_query = Category::select('id', 'title', 'description')->where('slug', $slug)->first();
        }

        // Return 404 page if category not found
        if ($category_query == null) {
            abort(404);
        }

        $page = request()->has('page') ? request()->get('page') : 1;

        // List of applications in the category page
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("category-apps-$slug-$page", function () use ($category_query) {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'votes', 'image', 'license', 'created_at')->orderBy('pinned', 'desc')->orderBy('id', 'desc')->where('category', '=', $category_query->id)->paginate(24);
            });
        } else {
            $apps = Application::select('title', 'slug', 'votes', 'image', 'license', 'created_at')->orderBy('pinned', 'desc')->orderBy('id', 'desc')->where('category', '=', $category_query->id)->paginate(24);
        }

        // Return 404 page if query is empty
        if ($apps->isEmpty() and $page > '1') {
            abort(404);
        }

        // List of top applications in category page
        if ($this->enable_cache == '1') {
            $popular_apps = Cache::rememberForever("category-top-apps-$category_query->id", function () use ($category_query) {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'image', 'votes', 'category')->orderBy('counter', 'desc')->where('category', '=', $category_query->id)->limit(10)->get();
            });
        } else {
            $popular_apps = Application::select('title', 'slug', 'image', 'votes', 'category')->orderBy('counter', 'desc')->where('category', '=', $category_query->id)->limit(10)->get();
        }

        if ($category_query->description != null) {
            $this->site_description = $category_query->description;
        }

        // Meta tags
        MetaTag::setTags([
            'title' => "$category_query->title - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => $category_query->title,
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => $category_query->title,
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name($category_query->title)
                    ->item(url()->current()),
            ]);

        // Return View
        return view('frontend::category')->with('apps', $apps)->with('popular_apps', $popular_apps)->with('category_query', $category_query)->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Platforms */
    public function platform()
    {
        $slug = request()->slug;

        // Check if platform exist

        if ($this->enable_cache == '1') {
            $platform_query = Cache::rememberForever("platform-apps-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return DB::table('platforms')->where('slug', request()->slug)->first();
            });
        } else {
            $platform_query = DB::table('platforms')->where('slug', request()->slug)->first();
        }

        // Return 404 page if platform not found
        if ($platform_query == null) {
            abort(404);
        }

        $page = request()->has('page') ? request()->get('page') : 1;

        // List of applications in the platform page
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("platform-apps-$slug-$page", function () use ($platform_query) {
                Cache::increment('total_cached');
                return Application::orderBy('pinned', 'desc')->orderBy('id', 'desc')->where('platform', '=', $platform_query->id)->paginate(24);
            });
        } else {
            $apps = Application::orderBy('pinned', 'desc')->orderBy('id', 'desc')->where('platform', '=', $platform_query->id)->paginate(24);
        }

        // Return 404 page if query is empty
        if ($apps->isEmpty() and $page > '1') {
            abort(404);
        }

        // List of top applications in platform page
        if ($this->enable_cache == '1') {
            $popular_apps = Cache::rememberForever("platform-top-apps-$slug", function () use ($platform_query) {
                Cache::increment('total_cached');
                return Application::orderBy('counter', 'desc')->where('platform', '=', $platform_query->id)->limit(10)->get();
            });
        } else {
            $popular_apps = Application::orderBy('counter', 'desc')->where('platform', '=', $platform_query->id)->limit(10)->get();
        }

        // Meta tags
        MetaTag::setTags([
            'title' => "$platform_query->title - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => $platform_query->title,
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => $platform_query->title,
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name($platform_query->title)
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::platform')->with('apps', $apps)->with('popular_apps', $popular_apps)->with('platform_query', $platform_query)->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Apps */
    public function app()
    {
        $slug = request()->slug;

        // Check if application exist
        if ($this->enable_cache == '1') {
            $app_query = Cache::rememberForever("app-query-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return Application::with('tagged')->where('slug', $slug)->first();
            });
        } else {
            $app_query = Application::with('tagged')->where('slug', $slug)->first();
        }

        // Return 404 page if application not found
        if ($app_query == null) {
            abort(404);
        }

        $app_id = $app_query->id;
        $category_id = $app_query->category;

        // Other apps in the category
        if ($this->enable_cache == '1') {
            $apps_category = Cache::remember("other-apps-category-$category_id", 600, function () use ($category_id) {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'image')->where('category', $category_id)->inRandomOrder()->limit(12)->get();
            });
        } else {
            $apps_category = Application::select('title', 'slug', 'image')->where('category', $category_id)->inRandomOrder()->limit(12)->get();
        }

        // Top apps in the category
        if ($this->enable_cache == '1') {
            $popular_apps = Cache::rememberForever("category-top-apps-$category_id", function () use ($category_id) {
                Cache::increment('total_cached');
                return Application::select('title', 'slug', 'image', 'votes', 'category')->orderBy('counter', 'desc')->where('category', '=', $category_id)->limit(10)->get();
            });
        } else {
            $popular_apps = Application::select('title', 'slug', 'image', 'votes', 'category')->orderBy('counter', 'desc')->where('category', '=', $category_id)->limit(10)->get();
        }

        // List of comments
        if ($this->enable_cache == '1') {
            $app_comments = Cache::rememberForever("comments-$slug", function () use ($app_id) {
                Cache::increment('total_cached');
                return DB::table('comments')->where('app_id', $app_id)->where('approval', 1)->orderBy('id', 'desc')->get();
            });
        } else {
            $app_comments = DB::table('comments')->where('app_id', $app_id)->where('approval', 1)->orderBy('id', 'desc')->get();
        }

        // Count comment
        if ($this->enable_cache == '1') {
            $comment_data = Cache::rememberForever("comment-count-$slug", function () use ($app_id) {
                Cache::increment('total_cached');
                return DB::table('comments')->select('rating')->where('app_id', $app_id)->where('approval', 1)->selectRaw('count(rating) AS total_rating')->groupBy('rating')->orderBy('rating', 'desc')->get();
            });
        } else {
            $comment_data = DB::table('comments')->select('rating')->where('app_id', $app_id)->where('approval', 1)->selectRaw('count(rating) AS total_rating')->groupBy('rating')->orderBy('rating', 'desc')->get();
        }

        // Format ratings
        $comment_order = array();
        foreach ($comment_data as $comment_c) {
            $comment_order[$comment_c->rating] = $comment_c->total_rating;
        }

        for ($x = 1; $x <= 5; $x++) {
            if (!array_key_exists("$x", $comment_order)) {
                $comment_order[$x] = 0;
            }
        }
        krsort($comment_order);

        // Total reviews
        $total_comments = array_sum($comment_order);

        $share_image = $app_query->image;

        // Default application image size
        $share_image_w = 200;
        $share_image_h = 200;

        // Use default images if images are not uploaded
        if (empty($app_query->image)) {
            $app_query->image = 'no_image.png'; // App image
            $share_image = 'default_share_image.png'; // Image to show when sharing
            $share_image_w = 600;
            $share_image_h = 315;
        }

        if ($app_query->custom_description != null) {
            $category_description = $app_query->custom_description;
        } else {
            $category_description = $app_query->description;
        }

        // Meta tags
        MetaTag::setTags([
            'title' => "$app_query->title - $this->site_title",
            'description' => $category_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => $app_query->title,
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $category_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/' . $share_image,
            'og_title' => $app_query->title,
            'og_description' => $category_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/' . $share_image, 'og_image_width' => $share_image_w, 'og_image_height' => $share_image_h,
            'og_type' => 'product',
        ]);

        // List of Categories
        if ($this->enable_cache == '1') {
            $category_data = Cache::get('categories');
        } else {
            $category_data = Category::select('id', 'title', 'slug', 'fa_icon', 'application_category', 'navbar', 'footer')->orderBy('sort', 'ASC')->get();
        }

        // List of Platforms
        if ($this->enable_cache == '1') {
            $platform_data = Cache::get('platforms');
        } else {
            $platform_data = DB::table('platforms')->select('id', 'title', 'slug')->orderBy('sort', 'ASC')->get();
        }

        foreach ($category_data as $category) {
            $category_name[$category->id] = $category->title;
            $category_slug[$category->id] = $category->slug;
            $category_schema_name[$category->id] = $category->application_category;
        }

        foreach ($platform_data as $platform) {
            $platform_name[$platform->id] = $platform->title;
            $platform_slug[$platform->id] = $platform->slug;
        }

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

        foreach ($applicationcategories as $cat_id => $cat_title) {
            $application_category[$cat_id] = $cat_title;
        }

        $schema_org_category = $category_schema_name[$app_query->category];

        if ($app_query->license != __('admin.free')) {
            $price = preg_replace("/[^0-9.,]/", "", $app_query->license);
        } else {
            $price = 0;
        }

        $schema_data = Schema::SoftwareApplication()
            ->name($app_query->title)
            ->operatingSystem($platform_name[$app_query->platform])
            ->offers(Schema::Offer()
                    ->price($price)
                    ->priceCurrency($this->schema_org_price_currency)
            );

        if ($app_query->total_votes != '0') {
            $schema_data->aggregateRating(Schema::aggregateRating()
                    ->ratingValue($app_query->votes)
                    ->ratingCount($app_query->total_votes)
            );
        }

        if (!empty($schema_org_category)) {
            $schema_data->applicationCategory('https://schema.org/' . $application_category[$schema_org_category] . '');
        }

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name($platform_name[$app_query->platform])
                    ->item(url($this->platform_base . '/' . $platform_slug[$app_query->platform])),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(3)
                    ->name($category_name[$app_query->category])
                    ->item(url($this->category_base . '/' . $category_slug[$app_query->category])),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(4)
                    ->name($app_query->title)
                    ->item(url()->current()),
            ]);

        $data_to_pass = array(
            'category_name' => $category_name[$app_query->category],
            'category_slug' => $category_slug[$app_query->category],
            'platform_name' => $platform_name[$app_query->platform],
            'platform_slug' => $platform_slug[$app_query->platform],
            'total_comments' => $total_comments,
        );

        $mysplit = explode(',', $app_query->screenshots);
        $screenshot_data = array_reverse($mysplit);

        // Update hits count
        Application::where('id', $app_id)->increment('hits');

        // Return View
        return view('frontend::app')->with('app_query', $app_query)->with('popular_apps', $popular_apps)->with('apps_category', $apps_category)->with('comment_order', $comment_order)->with('app_comments', $app_comments)->with('schema_data', $schema_data)->with('breadcrumb_schema_data', $breadcrumb_schema_data)->with('data_to_pass', $data_to_pass)->with('screenshot_data', $screenshot_data);
    }

    /** Search */
    public function search()
    {
        $search_query = request()->post('term');

        // Search query
        $apps = Application::orderBy('id', 'desc')->where('title', 'like', "%{$search_query}%")->limit(25)->get();

        // Meta tags
        MetaTag::setTags([
            'title' => "Search - $this->site_title",
        ]);

        // Return view
        return view('frontend::search')->with('apps', $apps)->with('search_query', $search_query);
    }

    /** Custom Pages */
    public function page()
    {
        $slug = request()->slug;

        // Page query
        if ($this->enable_cache == '1') {
            $page_query = Cache::rememberForever("page-query-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return DB::table('pages')->where('slug', $slug)->first();
            });
        } else {
            $page_query = DB::table('pages')->where('slug', $slug)->first();
        }

        // Return 404 page if page not found
        if ($page_query == null) {
            abort(404);
        }

        // Meta tags
        MetaTag::setTags([
            'title' => "$page_query->title - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => $page_query->title,
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => $page_query->title,
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
            'og_type' => 'article',
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name($page_query->title)
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::custom_page')->with('page_query', $page_query)->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Topics */
    public function topic()
    {

        $page = request()->has('page') ? request()->get('page') : 1;

        // List of topics
        if ($this->enable_cache == '1') {
            $all_topics = Cache::rememberForever("topics-$page", function () {
                Cache::increment('total_cached');
                return DB::table('topics')->orderBy('id', 'desc')->paginate(10);
            });
        } else {
            $all_topics = DB::table('topics')->orderBy('id', 'desc')->paginate(10);
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.topics') . " - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.topics'),
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.topics'),
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.topics'))
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::topics')->with('all_topics', $all_topics)->with('all_topics', $all_topics)->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Topic Item */
    public function topicitem()
    {
        $slug = request()->slug;

        // Topics query
        if ($this->enable_cache == '1') {
            $topic_query = Cache::rememberForever("topic-query-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return DB::table('topics')->where('slug', $slug)->first();
            });
        } else {
            $topic_query = DB::table('topics')->where('slug', $slug)->first();
        }

        // Return 404 page if news not found
        if ($topic_query == null) {
            abort(404);
        }

        $topic_id = $topic_query->id;

        // Topics list query
        if ($this->enable_cache == '1') {
            $topic_list_query = Cache::rememberForever("topics-query-$topic_id", function () use ($topic_id) {
                Cache::increment('total_cached');
                return DB::table('topic_items')->where('list_id', $topic_id)->first();
            });
        } else {
            $topic_list_query = DB::table('topic_items')->where('list_id', $topic_id)->first();
        }

        $topic_list_query = explode(',', $topic_list_query->app_list);
        $topic_list_query = array_filter($topic_list_query);

        // List of applications
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("topics-list-$slug", function () use ($topic_list_query) {
                Cache::increment('total_cached');
                return Application::orWhereIn('id', $topic_list_query)->orderBy('id', 'desc')->get();
            });
        } else {
            $apps = Application::orWhereIn('id', $topic_list_query)->orderBy('id', 'desc')->get();
        }

        $share_image = $topic_query->image;
        $share_image_w = 770;
        $share_image_h = 450;

        // Meta tags
        MetaTag::setTags([
            'title' => "$topic_query->title - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => $topic_query->title,
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/topics/' . $share_image,
            'og_title' => $topic_query->title,
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/topics/' . $share_image, 'og_image_width' => $share_image_w, 'og_image_height' => $share_image_h,
            'og_type' => 'article',
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.topics'))
                    ->item(url($this->topic_base)),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(3)
                    ->name($topic_query->title)
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::topic')->with('topic_query', $topic_query)->with('apps', $apps)->with('topic_list_query', $topic_list_query)->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** All News */
    public function allnews()
    {

        $page = request()->has('page') ? request()->get('page') : 1;

        // List of news
        if ($this->enable_cache == '1') {
            $all_news = Cache::rememberForever("news-$page", function () {
                Cache::increment('total_cached');
                return DB::table('news')->orderBy('id', 'desc')->paginate(10);
            });
        } else {
            $all_news = DB::table('news')->orderBy('id', 'desc')->paginate(10);
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.tech_news') . " - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.tech_news'),
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.tech_news'),
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.tech_news'))
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::news_all')->with('all_news', $all_news)->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** New Apps */
    public function new_apps()
    {

        // List of apps
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("news-apps", function () {
                Cache::increment('total_cached');
                return Application::orderBy('id', 'desc')->limit(30)->get();
            });
        } else {
            $apps = Application::orderBy('id', 'desc')->limit(30)->get();
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.new_apps') . " - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.new_apps'),
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.new_apps'),
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.new_apps'))
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::more_pages')->with('apps', $apps)->with('page_type', '1')->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Featured Apps */
    public function featured_apps()
    {

        // List of apps
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("featured-apps", function () {
                Cache::increment('total_cached');
                return Application::where('featured', 1)->orderBy('id', 'desc')->get();
            });
        } else {
            $apps = Application::where('featured', 1)->orderBy('id', 'desc')->get();
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.featured_apps') . " - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.featured_apps'),
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.featured_apps'),
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.featured_apps'))
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::more_pages')->with('apps', $apps)->with('page_type', '2')->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Must-Have Apps */
    public function must_have_apps()
    {

        // List of apps
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("must-have-apps", function () {
                Cache::increment('total_cached');
                return Application::where('must_have', 1)->orderBy('id', 'desc')->get();
            });
        } else {
            $apps = Application::where('must_have', 1)->orderBy('id', 'desc')->get();
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.must_have_apps') . " - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.must_have_apps'),
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.must_have_apps'),
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.must_have_apps'))
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::more_pages')->with('apps', $apps)->with('page_type', '3')->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Popular Apps in Last 24 Hours */
    public function popular_apps_24_hours()
    {

        // List of apps
        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("popular-apps-24-hours", function () {
                Cache::increment('total_cached');
                return Application::orderBy('hits', 'desc')->limit(33)->get();
            });
        } else {
            $apps = Application::orderBy('hits', 'desc')->limit(33)->get();
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.popular_apps_24_hours') . " - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.popular_apps_24_hours'),
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.popular_apps_24_hours'),
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.popular_apps_24_hours'))
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::more_pages')->with('apps', $apps)->with('page_type', '4')->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Reading Time Calculator */
    public function reading_time($text = "", $word_per_second = 2)
    {
        $word_count = count(explode(" ", $text));

        $reading_time = round($word_count / $word_per_second);

        if ($reading_time < 60) {
            $second = $reading_time;
            return "$second sec";
        } else if ($reading_time < 3600) {
            $minute = ceil($reading_time / 60);
            return "$minute min";
        } else {
            $hour = floor($reading_time / 3600);
            return "$hour hour";
        }
    }

    /** News */
    public function news()
    {

        $slug = request()->slug;

        // News query
        if ($this->enable_cache == '1') {
            $news_query = Cache::rememberForever("news-query-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return \App\News::where('slug', $slug)->with(['tagged'])->first();
            });
        } else {
            $news_query = \App\News::where('slug', $slug)->with(['tagged'])->first();
        }

        //dd(\App\News::where('slug', $slug)->with(['tagged'])->first());
        // Return 404 page if news not found
        if ($news_query == null) {
            abort(404);
        }

        $share_image = $news_query->image;
        $share_image_w = 770;
        $share_image_h = 450;
        //dd($news_query);
        // Meta tags
        MetaTag::setTags([
            'title' => "$news_query->title - $this->site_title",
            'description' => $news_query->description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => $news_query->title,
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $news_query->description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/news/' . $share_image,
            'og_title' => $news_query->title,
            'og_description' => $news_query->description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/news/' . $share_image, 'og_image_width' => $share_image_w, 'og_image_height' => $share_image_h,
            'og_type' => 'article',
        ]);

        // Other News
        if ($this->enable_cache == '1') {
            $other_news = Cache::rememberForever("other-news-$slug", function () use ($news_query) {
                Cache::increment('total_cached');
                return \App\News::where('id', '!=', $news_query->id)->with(['tagged'])->inRandomOrder()->limit(2)->get();
            });
        } else {
            $other_news = \App\News::where('id', '!=', $news_query->id)->with(['tagged'])->inRandomOrder()->limit(2)->get();
        }

        // Reading Time
        $reading_time = $this->reading_time($news_query->details, "2");

        // Schema.org Breadcrumbs 12
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.tech_news'))
                    ->item(url($this->news_base)),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(3)
                    ->name($news_query->title)
                    ->item(url()->current()),
            ]); 
        //dd(isset($news_query->tagged) );
        //dd($news_query->tagged);
        //dd($news_query);
        // Return view
            //dd($news_query);
        return view('frontend::news')->with('page_query', $news_query)->with('other_news', $other_news)->with('reading_time', $reading_time)->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Redirect */
    public function redirect()
    {
        $slug = request()->slug;

        // Check if application exist
        if ($this->enable_cache == '1') {
            $app_query = Cache::rememberForever("app-query-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return Application::where('slug', $slug)->first();
            });
        } else {
            $app_query = Application::where('slug', $slug)->first();
        }

        // Return 404 page if application not found
        if ($app_query == null) {
            abort(404);
        }

        // Meta tags
        MetaTag::setTags([
            'title' => "$app_query->title - $this->site_title",
            'canonical' => request()->getSchemeAndHttpHost() . '/app/' . $app_query->slug,
        ]);

        // Return View
        return view('frontend::redirect')->with('app_query', $app_query);
    }

    /** Random App */
    public function random()
    {
        // Grab a random link
        $random_app = Application::select('id', 'slug')->inRandomOrder()->first();

        // Redirect to link
        return redirect("/$this->app_base/$random_app[slug]");
    }

    /** App Submission */
    public function submission()
    {
        // Check if submission form is enabled
        if ($this->show_submission_form != '1') {
            abort(404);
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.submit_your_app') . " - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.submit_your_app') . " - $this->site_title",
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.submit_your_app') . " - $this->site_title",
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name(__('general.submit_your_app'))
                    ->item(url()->current()),
            ]);

        // Return view
        return view('frontend::submission')->with('breadcrumb_schema_data', $breadcrumb_schema_data);
    }

    /** Tags */
    public function tags()
    {

        $slug = request()->slug;

        if ($this->enable_cache == '1') {
            $apps = Cache::rememberForever("tags-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return Application::withAnyTag([$slug])->orderBy('id', 'desc')->get();
            });
        } else {
            $apps = Application::withAnyTag([$slug])->orderBy('id', 'desc')->get();
        }

        if ($this->enable_cache == '1') {
            $tag_title = Cache::rememberForever("tag-title-$slug", function () use ($slug) {
                Cache::increment('total_cached');
                return DB::table('tagging_tags')->where('slug', $slug)->first();
            });
        } else {
            $tag_title = DB::table('tagging_tags')->where('slug', $slug)->first();
        }

        // Return 404 page if tag not found
        if ($tag_title == null) {
            abort(404);
        }

        // Meta tags
        MetaTag::setTags([
            'title' => __('general.tagged_with') . " \"$tag_title->name\" - $this->site_title",
            'description' => $this->site_description,
            'twitter_site' => $this->twitter_account,
            'twitter_title' => __('general.tagged_with') . " \"$tag_title->name\"",
            'twitter_card' => 'summary',
            'twitter_url' => url()->current(),
            'twitter_description' => $this->site_description,
            'twitter_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png',
            'og_title' => __('general.tagged_with') . " \"$tag_title->name\"",
            'og_description' => $this->site_description,
            'og_url' => url()->current(),
            'og_image' => request()->getSchemeAndHttpHost() . '/images/default_share_image.png', 'og_image_width' => 600, 'og_image_height' => 315,
        ]);

        // Schema.org Breadcrumbs
        $breadcrumb_schema_data = Schema::BreadcrumbList()
            ->itemListElement([
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(1)
                    ->name($this->site_title)
                    ->item(url('')),
                \Spatie\SchemaOrg\Schema::ListItem()
                    ->position(2)
                    ->name($tag_title->name)
                    ->item(url()->current()),
            ]);

        return view('frontend::tags')->with('apps', $apps)->with('tag_title', $tag_title->name)->with('breadcrumb_schema_data', $breadcrumb_schema_data);

    }

    /** Crontab */
    public function crontab($slug)
    {
        // Grab crontab code
        $crontab_check = DB::table('settings')->where('name', 'crontab_code')->first();

        // Check if crontab code is valid
        if ($crontab_check->value == $slug) {

            // Clear cache
            Cache::flush();

            // Clear entries from table
            DB::table('votes')->truncate();

            // Return success message
            return "OK";
        }
    }

    /** Hourly Crontab */
    public function hourly_crontab($slug)
    {
        // Grab crontab code
        $crontab_check = DB::table('settings')->where('name', 'hourly_crontab_code')->first();

        // Check if crontab code is valid
        if ($crontab_check->value == $slug) {

            $hour = date("H");

            if ($hour == '00') {
                // Reset hits
                Application::update(['hits' => '0']);
                // Clear cache
                Cache::flush();
            } else {
                // Clear cache
                Cache::flush();
            }

            // Return success message
            return "OK";
        }
    }

}
