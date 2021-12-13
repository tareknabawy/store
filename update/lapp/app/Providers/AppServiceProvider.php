<?php

namespace App\Providers;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(255);

        $this->loadViews();

        $this->app->singleton('site_lang', function () {

            // Retrieve settings
            $site_settings = DB::table('settings')->get();

            foreach ($site_settings as $setting) {
                $settings[$setting->name] = $setting->value;
            }
            
            return $settings['site_language'];

        });

        // Set default site language
        App::setLocale(app('site_lang'));
    }

    private function packagePath($path)
    {
        return __DIR__ . "../../$path";
    }

    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources/views');
        $this->loadViewsFrom($viewsPath, 'frontend');

    }

}
