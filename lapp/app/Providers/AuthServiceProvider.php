<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Get number of total cached pages
        $total_cached = Cache::get('total_cached');
        
        if (is_null($total_cached)) {
            $total_cached = 0;
        }

        // Pending comments
        $pending_comments = DB::table('comments')->where('approval', '=', '0')->count('id');

        // Pending submissions
        $pending_submissions = DB::table('submissions')->count('id');

        // Return view
        View::share(['total_cached' => $total_cached, 'pending_comments' => $pending_comments, 'pending_submissions' => $pending_submissions]);
        
    }
}
