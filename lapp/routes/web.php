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

Route::get('sitemap.xml','SiteMapFinalController@sitemap');
Route::get('sitemaps/{name}/{page}/sitemap.xml','SiteMapFinalController@viewer');

Route::get('/', 'SiteController@index')->name('home');
Route::get("/$link_base[category_base]/{slug}", 'SiteController@category')->name('category.show');
Route::get("/$link_base[platform_base]/{slug}", 'SiteController@platform')->name('platform.show');
Route::get("/$link_base[app_base]/random", 'SiteController@random')->name('random.show');
Route::get("/$link_base[tag_base]/{slug}", 'SiteController@tags')->name('tag.show');
Route::get('/redirect/{slug}', 'SiteController@redirect');
Route::get("/$link_base[app_base]/{slug}", 'SiteController@app')->name('app.show');
Route::get("/$link_base[page_base]/{slug}", 'SiteController@page')->name('page.show');
Route::get("/$link_base[news_base]", 'SiteController@allnews');
Route::get("/$link_base[topic_base]", 'SiteController@topic');
Route::get("/$link_base[news_base]/{slug}", 'SiteController@news')->name('news.show');
Route::get("/$link_base[topic_base]/{slug}", 'SiteController@topicitem')->name('topicitem.show');
Route::get('/crontab/{slug}', 'SiteController@crontab');
Route::get('/hourly-crontab/{slug}', 'SiteController@hourly_crontab');
Route::post('/search', 'SiteController@search');
Route::get('/rss', 'RSSController@index');
#Route::get('/sitemap.xml', 'SitemapController@index');
#Route::get("/sitemap/$link_base[app_base]", 'SitemapController@apps');
#Route::get("/sitemap/$link_base[page_base]", 'SitemapController@pages');
#Route::get("/sitemap/$link_base[news_base]", 'SitemapController@news');
#Route::get("/sitemap/$link_base[category_base]", 'SitemapController@categories');
#Route::get("/sitemap/$link_base[platform_base]", 'SitemapController@platforms');
#Route::get("/sitemap/$link_base[topic_base]", 'SitemapController@topics');
#Route::get("/sitemap/$link_base[tag_base]", 'SitemapController@tags');
Route::get('/download/{id}', 'FileDownloadController@show');
Route::post('/comment', 'FrontendCommentController@store');
Route::get('/submit-app', 'SiteController@submission');
Route::post('/submission', 'FrontendSubmissionController@store');
Route::post('/vote/{id}', 'VoteController@show');

Route::get('/new-apps', 'SiteController@new_apps');
Route::get('/featured-apps', 'SiteController@featured_apps');
Route::get('/must-have-apps', 'SiteController@must_have_apps');
Route::get('/popular-apps-in-last-24-hours', 'SiteController@popular_apps_24_hours');
Route::get('/crawler/{slug}', 'AppCrawlerController@index');



Route::prefix('user/')->name('user.')->middleware(['auth'])->group(function(){
    Route::get('/submit-app', 'ProfileController@submit_app')->name('submit-app');
    Route::get('/submission/{submission}', 'ProfileController@show_submission')->name('submission.show');
    Route::post('/submission', 'ProfileController@store_app')->name('submission');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/submissions', 'ProfileController@submissions')->name('submissions');
    Route::get('/applications', 'ProfileController@applications')->name('applications');
});

//,'CheckRole:ADMIN'
Route::prefix('admin/')->middleware(['auth','CheckRole:ADMIN'])->group(function(){
    Route::get('/settings/clear_cache', 'SettingController@clear_cache');
    Route::get('/platforms/order', 'PlatformController@order');
    Route::get('/categories/order', 'CategoryController@order');
    Route::get('/pages/order', 'PageController@order');
    Route::get('/sliders/status/{id}', 'SliderController@status');
    Route::post('/topics/details', 'TopicController@details');
    Route::resource('/users', 'UserController');
    Route::post('/user-block/{user}','UserController@block')->name('user-block');
    Route::resource('/apps', 'ApplicationController');
    Route::resource('/news', 'NewsController');
    Route::resource('/comments', 'CommentController');
    Route::resource('/scraper', 'ScraperController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/platforms', 'PlatformController');
    Route::resource('/translations', 'TranslationController');
    Route::resource('/submissions', 'SubmissionController');
    Route::resource('/sliders', 'SliderController');
    Route::resource('/topics', 'TopicController');
    Route::resource('/topic', 'TopicItemController');
    Route::resource('/pages', 'PageController');
    Route::resource('/ads', 'AdController');
    Route::post('/multiple-file-upload/upload', 'MultipleUploadController@upload')->name('upload');
    Route::post('/multiple-file-upload/delete', 'MultipleUploadController@delete')->name('delete');
    Route::get('/settings', 'SettingController@index');
    Route::post('/settings', 'SettingController@update');
    Route::get('/permalinks', 'SettingController@permalinks');
    Route::post('/permalinks', 'SettingController@permalinksupdate');
    Route::get('/scraper_categories', 'CrawlerController@index');
    Route::post('/scraper_categories', 'CrawlerController@update');
    Route::get('/search', 'ApplicationController@search');
    Route::get('/account_settings', 'HomeController@accountsettingsform');
    Route::post('/account_settings', 'HomeController@accountsettings')->name('accountsettings');
    Route::get('/', 'ApplicationController@index')->name('admin.index');
});




Auth::routes();

Route::get('/admin/random_key', function () {
    define('AES_256_CBC', 'aes-256-cbc');
    $encryption_key = openssl_random_pseudo_bytes(32);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
    $data = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 32);
    return openssl_encrypt($data, AES_256_CBC, $encryption_key, 0, $iv);
})->middleware('auth');