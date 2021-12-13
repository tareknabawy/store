<?php
namespace App\Http\Controllers;

use App;
use Storage;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // Language names in their own language
        $language_translation = DB::table('translations')->get()
            ->pluck('language', 'code');
        $language_translation = $language_translation->toArray();

        // Pass data to views
        View::share(['language_translation' => $language_translation]);
    }

    /** Index */
    public function index()
    {
        $generate = request()->get('generate');

        // Generate crontab link
        if ($generate == 'crontab')
        {
            $rand = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 25)) , 0, 25);

            // Update crontab link
            DB::table('settings')->where('name', 'crontab_code')
                ->update(['value' => $rand]);

            // Redirect to settings page
            return redirect('admin/settings')->with('success', __('admin.new_link_generated') . ": " . request()
                ->getSchemeAndHttpHost() . "/crontab/$rand");
        }

        // Generate hourly crontab link
        if ($generate == 'hourly-crontab')
        {
            $rand = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 25)) , 0, 25);

            // Update crontab link
            DB::table('settings')->where('name', 'hourly_crontab_code')
                ->update(['value' => $rand]);

            // Redirect to settings page
            return redirect('admin/settings')->with('success', __('admin.new_link_generated') . ": " . request()
                ->getSchemeAndHttpHost() . "/hourly-crontab/$rand");
        }

        // Generate auto submission crontab link
        if ($generate == 'submission_crontab')
        {
            $rand = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 25)) , 0, 25);

            // Update crontab link
            DB::table('settings')->where('name', 'submission_crontab_code')
                ->update(['value' => $rand]);

            // Redirect to settings page
            return redirect('admin/settings')->with('success', __('admin.new_link_generated') . ": " . request()
                ->getSchemeAndHttpHost() . "/crawler/$rand");
        }

        $navbar_colors = array(
            '1' => 'Purple',
            '2' => 'Turquoise',
            '3' => 'Grey',
            '4' => 'Pink',
            '5' => 'Green',
            '6' => 'Orange',
            '7' => 'Indigo',
            '8' => 'Blue',
            '9' => 'Red',
            '10' => 'Brown',
            '11' => 'Gradient 1',
            '12' => 'Gradient 2',
            '13' => 'Gradient 3',
            '14' => 'Gradient 4',
            '15' => 'Gradient 5',
            '16' => 'Gradient 6',
            '17' => 'Gradient 7'
        );

        // Retrieve settings
        $settings = Setting::orderBy('id', 'desc')->get();

        // Return view
        return view('adminlte::settings.site')
            ->with('navbar_colors', $navbar_colors)->with('settings', $settings);
    }

     // Checkbox Update Function
     public function checkbox_update($box, $box_data)
     {
       if ($box_data == 'on')
       {
           DB::update("update settings set value = '1' WHERE name = '$box'");
       }
       else
       {
           DB::update("update settings set value = '0' WHERE name = '$box'");
       }
     }

    /** Update */
    public function update(Request $request)
    {
        foreach ($request->except(array(
            '_token',
            '_method'
        )) as $key => $value)
        {

            $value = addslashes($value);

            // Update settings
            DB::update("update settings set value = '$value' WHERE name = '$key'");

            $this->checkbox_update('random_app_link', $request->get('random_app_link'));
            $this->checkbox_update('show_cookie_bar', $request->get('show_cookie_bar'));
            $this->checkbox_update('show_submission_form', $request->get('show_submission_form'));
            $this->checkbox_update('auto_submission', $request->get('auto_submission'));
            $this->checkbox_update('show_rss_feed', $request->get('show_rss_feed'));
            $this->checkbox_update('use_text_logo', $request->get('use_text_logo'));
            $this->checkbox_update('breadcrumbs', $request->get('breadcrumbs'));
            $this->checkbox_update('ping_google', $request->get('ping_google'));
            $this->checkbox_update('enable_cache', $request->get('enable_cache'));
            $this->checkbox_update('auto_comment_approval', $request->get('auto_comment_approval'));
            $this->checkbox_update('schema_breadcrumbs', $request->get('schema_breadcrumbs'));
            $this->checkbox_update('cloudflare_ip', $request->get('cloudflare_ip'));
            $this->checkbox_update('reading_time', $request->get('reading_time'));
            
            // Check if the default share image has been uploaded
            if ($request->hasFile('default_share_image'))
            {
                $image = $request->file('default_share_image');
                $filename = 'default_share_image.png';
                $location = public_path('images/' . $filename);
                Image::make($image)->resize(600, 315)
                    ->save($location);
            }

            // Check if the default share image has been uploaded
            if ($request->hasFile('default_app_image'))
            {
                $image = $request->file('default_app_image');
                $filename = 'no_image.png';
                $location = public_path('images/' . $filename);
                Image::make($image)->resize(200, 200)
                    ->save($location);
            }

            // Check if the site logo has been uploaded
            if ($request->hasFile('site_logo'))
            {
                $image = $request->file('site_logo');
                $filename = 'logo.png';
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
            }

            // Check if the favicon has been uploaded
            if ($request->hasFile('favicon'))
            {
                $image = $request->file('favicon');
                $filename = 'favicon.png';
                $location = public_path('images/' . $filename);
                Image::make($image)->resize(192, 192)
                    ->save($location);
            }
        }

        // Clear cache
        Cache::flush();

        // Redirect to settings page
        return redirect('admin/settings')->with('success', __('admin.data_updated'));
    }

    /** Permalinks */
    public function permalinks()
    {

        // Retrieve settings
        $settings = Setting::orderBy('id', 'desc')->get();

        // Return view
        return view('adminlte::settings.permalinks')
            ->with('settings', $settings);
    }

    /** Permalinks Update */
    public function permalinksupdate(Request $request)
    {

        $this->validate($request, [
            'app_base' => 'required',
            'news_base' => 'required',
            'category_base' => 'required',
            'platform_base' => 'required',
            'page_base' => 'required',
            'tag_base' => 'required',
        ]);

        foreach ($request->except(array(
            '_token',
            '_method'
        )) as $key => $value)
        {

            $value = addslashes($value);

            // Update settings
            DB::update("update settings set value = '$value' WHERE name = '$key'");

        }

        // Clear cache
        Cache::flush();

        // Redirect to settings page
        return redirect('admin/permalinks')->with('success', __('admin.data_updated'));
    }

    /** Clear Cache */
    public function clear_cache()
    {
        // Clear cache
        Cache::flush();

        // Redirect to list of applications
        return redirect('admin/apps')
            ->with('success', __('admin.system_cache_cleared'));
    }

}