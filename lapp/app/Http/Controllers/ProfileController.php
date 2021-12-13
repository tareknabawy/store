<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Application;
use App\Category;
use App\Topic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use MetaTag;
use Spatie\SchemaOrg\Schema;
use Intervention\Image\ImageManagerStatic as Image;
    


class ProfileController extends Controller
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

    public function submit_app(Request $request)
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
        return view('vendor.profile.submissions.create')->with('breadcrumb_schema_data', $breadcrumb_schema_data);

    }
    public function submission(Request $request,\App\Submission $submission){
        $submission = \App\Submission::where('id',$request->id)->where('user_id',auth()->id())->firstOrFail();
        dd($submission);
    }
    public function submissions(Request $request){
        return view('vendor.profile.submissions.index');
    }
    public function applications(Request $request){
        return view('vendor.profile.applications.index');
    }
    public function store_app(Request $request)
    { 

        $this->validate($request, [
            //'name' => 'required',
            //'email' => 'required',
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'platform' => 'required',
            'developer' => 'required',
            'url' => 'required',
            'image' =>
            'required
                      |image
                      |mimes:jpeg,png,jpg,gif,svg
                      |max:500',
        ]);

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/submissions/' . $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $file_name = $filename;
        }

        $detailed_desc = request()->detailed_description;
        $detailed_desc = nl2br($detailed_desc);

        $client_ip = 'NA';
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){ 
            $client_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else{ 
            $client_ip = $_SERVER['REMOTE_ADDR'];
        } 
        $ip = $request->ip();
        if($client_ip!='NA'){
            $ip=$client_ip;
        }


        DB::table('submissions')->insert(
            [
                'user_id'=>auth()->id(),
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'title' => request()->title,
                'description' => request()->description,
                'category' => request()->category,
                'platform' => request()->platform,
                'developer' => request()->developer,
                'url' => request()->url,
                'license' => request()->license,
                'file_size' => request()->file_size,
                'image' => $file_name,
                'details' => $detailed_desc,
                'ip' => $client_ip,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );
        return redirect()->route('user.submissions')->with('success', __('admin.data_added'));
    }

    public function index(Request $request)
    {
        return view('vendor.profile.index');
    }
    public function my_submissions(Request $request)
    {
        
    }



    
}
