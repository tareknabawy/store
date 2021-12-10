<?php
namespace App\Http\Controllers;

use App\Application;
use App\News;
use App\Page;
use App\Topic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class SitemapController extends Controller
{

    public function __construct()
    {
        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting
                    ->name] = $setting->value;
        }

        $this->app_base = $settings['app_base'];
        $this->news_base = $settings['news_base'];

        // Pass data to views
        View::share(['settings' => $settings]);
    }

    /** Index */
    public function index()
    {
        // Return view
        return response()->view('frontend::sitemap.index')
            ->header('Content-Type', 'text/xml');
    }

    /** Apps */
    public function apps()
    {
        // List of the applications
        $apps = Cache::rememberForever("sitemap-apps", function () {
            Cache::increment('total_cached');
            return Application::latest()->get();
        });

        // Return view
        return response()
            ->view('frontend::sitemap.apps', ['apps' => $apps])->header('Content-Type', 'text/xml');
    }

    /** Pages */
    public function pages()
    {
        // List of the custom pages
        $pages = Cache::rememberForever("sitemap-pages", function () {
            Cache::increment('total_cached');
            return Page::latest()->get();
        });

        // Return view
        return response()
            ->view('frontend::sitemap.pages', ['pages' => $pages])->header('Content-Type', 'text/xml');
    }

    /** News */
    public function news()
    {
        // List of the news
        $news = Cache::rememberForever("sitemap-news", function () {
            Cache::increment('total_cached');
            return News::latest()->get();
        });

        // Return view
        return response()
            ->view('frontend::sitemap.news', ['news' => $news])->header('Content-Type', 'text/xml');
    }

    /** Categories */
    public function categories()
    {
        // List of the categories
        $categories = Cache::rememberForever("sitemap-categories", function () {
            Cache::increment('total_cached');
            return DB::select(DB::raw("
            SELECT c.slug,(select count(*) from applications where category = c.id) as count FROM categories c"));
        });

        // Return view
        return response()->view('frontend::sitemap.categories', ['categories' => $categories])->header('Content-Type', 'text/xml');
    }

    /** Platforms */
    public function platforms()
    {
        // List of the platforms
        $platforms = Cache::rememberForever("sitemap-platforms", function () {
            Cache::increment('total_cached');
            return DB::select(DB::raw("SELECT c.slug,(select count(*) from applications where platform = c.id) as count FROM platforms c"));
        });

        // Return view
        return response()->view('frontend::sitemap.platforms', ['platforms' => $platforms])->header('Content-Type', 'text/xml');
    }

    /** Topics */
    public function topics()
    {
        // List of the topics
        $topics = Cache::rememberForever("sitemap-topics", function () {
            Cache::increment('total_cached');
            return Topic::latest()->get();
        });

        // Return view
        return response()
            ->view('frontend::sitemap.topics', ['topics' => $topics])->header('Content-Type', 'text/xml');
    }

    /** Tags */
    public function tags()
    {
        // List of the tags
        $tags = Cache::rememberForever("sitemap-tags", function () {
            Cache::increment('total_cached');
            return DB::table('tagging_tags')->orderBy('id', 'desc')->get();
        });

        // Return view
        return response()
            ->view('frontend::sitemap.tags', ['tags' => $tags])->header('Content-Type', 'text/xml');
    }


}
