<?php

namespace App\Http\Controllers;

use App;
use App\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Raulr\GooglePlayScraper\Scraper;

class AppCrawlerController extends Controller
{
    public function __construct()
    {

        // List of categories
        $platforms = DB::table('platforms')->get();

        foreach ($platforms as $platform) {
            $platform_name[$platform->title] = $platform->id;
        }

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        $this->google_play_default_country = $settings['google_play_default_country'];
        $this->google_play_default_language = $settings['google_play_default_language'];
        $this->crawler_categories = $settings['crawler_categories'];
        $this->android_platform_id = $platform_name['Android'];
        $this->auto_submission = $settings['auto_submission'];
        $this->screenshot_count = $settings['screenshot_count'];

        $allowed_categories = array();
        foreach (json_decode($this->crawler_categories) as $crawler_name => $crawler_id) {
            if (!empty($crawler_id)) {
                $allowed_categories[$crawler_name] = $crawler_id;
            }

        }
        $this->allowed_categories = $allowed_categories;

    }

    /** Index */
    public function index($slug)
    {

        if ($this->auto_submission == '1') {

            // Grab crontab code
            $crontab_check = DB::table('settings')->where('name', 'submission_crontab_code')->first();

            // Check if crontab code is valid
            if ($crontab_check->value == $slug) {

                $app_query = DB::table('applications')->inRandomOrder()->where('url', 'LIKE', 'https://play.google.com/store/apps/details?id=%')->limit(1)->get();
                $searchquery = $app_query[0]->title;

                $scraper = new Scraper();

                $apps = $scraper->getSearch($searchquery, 'all', 'all', $this->google_play_default_language, $this->google_play_default_country);
                $count = count($apps);

                $scraper = new Scraper();

                $exit = 0;

                for ($x = 0; $x <= $count - 1; $x++) {

                    if ($exit == '1') {
                        echo "OK";

                        // Clear cache
                        Cache::flush();
                        exit;
                    }

                    $app_id = $apps[$x]['id'];

                    $app_count = DB::table('applications')
                        ->where('url', 'LIKE', "%$app_id")
                        ->count();

                    if ($app_count == '0') {
                        $app = $scraper->getApp($app_id, $this->google_play_default_language, $this->google_play_default_country);

                        $categories = $app['categories'][0];

                        if (array_key_exists($categories, $this->allowed_categories)) {

                            $screenshots = implode(',', $app['screenshots']);

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

                            // Remove if first line of detailed description contains <br>
                            $detailed_description = @preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $detailed_description);

                            $max_screenshots = $this->screenshot_count;

                            if ($max_screenshots != '0') {

                                $explode_screenshots = explode(",", $screenshots);
                                $total_screenshots = count($explode_screenshots);

                                if ($total_screenshots >= $max_screenshots) {
                                    $total_screenshots = $max_screenshots;
                                }

                                $ss_array = array();

                                for ($x = 0; $x <= $total_screenshots - 1; $x++) {$ss_filename = rand(111111111, 999999999999) . '.jpg';

                                    // Download screenshots from Google Play Store to temp folder

                                    Image::make($explode_screenshots[$x])->
                                        save(public_path('screenshots/temp/' . $ss_filename));
                                    $ss_tempimage = "screenshots/temp/$ss_filename";
                                    $ss_location = "screenshots/$ss_filename";

                                    Image::make($ss_tempimage)->save($ss_location); // Resize image

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

                            $image = $app['image'];
                            $path = $image;
                            $filename = rand(1111111, 9999199) . '.png';

                            // Download image from Google Play Store to temp folder
                            Image::make($path)->save(public_path('images/temp/' . $filename));
                            $tempimage = "images/temp/$filename";
                            $location = "images/$filename";

                            Image::make($tempimage)->resize(200, 200)->save($location); // Resize image

                            $last_id = DB::table('applications')->insertGetId(array(
                                'title' => $app['title'],
                                'description' => $description,
                                'details' => $detailed_description,
                                'image' => $filename,
                                'file_size' => $app['size'],
                                'license' => $app_price,
                                'developer' => $app['author'],
                                'url' => $app['url'],
                                'type' => '2',
                                'platform' => $this->android_platform_id,
                                'category' => $this->allowed_categories[$categories],
                                'slug' => rand(1111111, 22222222222),
                                'screenshots' => $screenshots_list,
                                'created_at' => \Carbon\Carbon::now()
                            ));

                            $app = Application::find($last_id);
                            $app->slug = null;
                            $app->save();
                            $app->update(['title' => $app->title]);

                            $exit = 1;

                        }
                    }
                }
            }
        }
    }

}
