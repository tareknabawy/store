<?php

namespace App\Http\Middleware;

use Closure;

class NotBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->blocked==0 ) {
            return $next($request);
        }
		abort(403);
        
    }
}
