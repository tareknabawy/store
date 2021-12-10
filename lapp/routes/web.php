<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$link_base = Cache::rememberForever('settings', function () {
    return DB::table('settings')
        ->whereIn('id', [27, 28, 29, 30, 31, 32, 33])
        ->pluck('value', 'name');

});

Route::get('/', 'SiteController@index');
Route::get("/$link_base[category_base]/{slug}", 'SiteController@category');
Route::get("/$link_base[platform_base]/{slug}", 'SiteController@platform');
Route::get("/$link_base[app_base]/random", 'SiteController@random');
Route::get("/$link_base[tag_base]/{slug}", 'SiteController@tags');
Route::get('/redirect/{slug}', 'SiteController@redirect');
Route::get("/$link_base[app_base]/{slug}", 'SiteController@app');
Route::get("/$link_base[page_base]/{slug}", 'SiteController@page');
Route::get("/$link_base[news_base]", 'SiteController@allnews');
Route::get("/$link_base[topic_base]", 'SiteController@topic');
Route::get("/$link_base[news_base]/{slug}", 'SiteController@news');
Route::get("/$link_base[topic_base]/{slug}", 'SiteController@topicitem');
Route::get('/crontab/{slug}', 'SiteController@crontab');
Route::get('/hourly-crontab/{slug}', 'SiteController@hourly_crontab');
Route::post('/search', 'SiteController@search');
Route::get('/rss', 'RSSController@index');
Route::get('/sitemap.xml', 'SitemapController@index');
Route::get("/sitemap/$link_base[app_base]", 'SitemapController@apps');
Route::get("/sitemap/$link_base[page_base]", 'SitemapController@pages');
Route::get("/sitemap/$link_base[news_base]", 'SitemapController@news');
Route::get("/sitemap/$link_base[category_base]", 'SitemapController@categories');
Route::get("/sitemap/$link_base[platform_base]", 'SitemapController@platforms');
Route::get("/sitemap/$link_base[topic_base]", 'SitemapController@topics');
Route::get("/sitemap/$link_base[tag_base]", 'SitemapController@tags');
Route::get('/download/{id}', 'FileDownloadController@show');
Route::post('/comment', 'FrontendCommentController@store');
Route::get('/submit-app', 'SiteController@submission');
Route::post('/submission', 'FrontendSubmissionController@store');
Route::post('/vote/{id}', 'VoteController@show');
Route::get('/admin/settings/clear_cache', 'SettingController@clear_cache');
Route::get('/admin/platforms/order', 'PlatformController@order');
Route::get('/admin/categories/order', 'CategoryController@order');
Route::get('/admin/pages/order', 'PageController@order');
Route::get('/admin/sliders/status/{id}', 'SliderController@status');
Route::get('/new-apps', 'SiteController@new_apps');
Route::get('/featured-apps', 'SiteController@featured_apps');
Route::get('/must-have-apps', 'SiteController@must_have_apps');
Route::get('/popular-apps-in-last-24-hours', 'SiteController@popular_apps_24_hours');
Route::post('/admin/topics/details', 'TopicController@details');
Route::resource('/admin/apps', 'ApplicationController');
Route::resource('/admin/news', 'NewsController');
Route::resource('/admin/comments', 'CommentController');
Route::resource('/admin/scraper', 'ScraperController');
Route::resource('/admin/categories', 'CategoryController');
Route::resource('/admin/platforms', 'PlatformController');
Route::resource('/admin/translations', 'TranslationController');
Route::resource('/admin/submissions', 'SubmissionController');
Route::resource('/admin/sliders', 'SliderController');
Route::resource('/admin/topics', 'TopicController');
Route::resource('/admin/topic', 'TopicItemController');
Route::resource('/admin/pages', 'PageController');
Route::resource('/admin/ads', 'AdController');
Route::post('/admin/multiple-file-upload/upload', 'MultipleUploadController@upload')->name('upload');
Route::post('/admin/multiple-file-upload/delete', 'MultipleUploadController@delete')->name('delete');
Route::get('/admin/settings', 'SettingController@index');
Route::post('/admin/settings', 'SettingController@update');
Route::get('/admin/permalinks', 'SettingController@permalinks');
Route::post('/admin/permalinks', 'SettingController@permalinksupdate');
Route::get('/admin/scraper_categories', 'CrawlerController@index');
Route::post('/admin/scraper_categories', 'CrawlerController@update');
Route::get('/admin/search', 'ApplicationController@search');
Route::get('/admin/account_settings', 'HomeController@accountsettingsform');
Route::post('/admin/account_settings', 'HomeController@accountsettings')->name('accountsettings');
Route::get('/admin', 'ApplicationController@index');
Route::get('/crawler/{slug}', 'AppCrawlerController@index');

Auth::routes([
    'register' => false,
    'reset' => true,
    'verify' => false,
]);

Route::get('/admin/random_key', function () {
    define('AES_256_CBC', 'aes-256-cbc');
    $encryption_key = openssl_random_pseudo_bytes(32);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
    $data = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 32);
    return openssl_encrypt($data, AES_256_CBC, $encryption_key, 0, $iv);
})->middleware('auth');