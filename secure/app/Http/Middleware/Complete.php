<?php

namespace App\Http\Middleware;

use Closure;

class Complete
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
        if(auth()->check() && auth()->user()->first_login){
            return redirect()->route('setting');
        }
        return $next($request);
    }
}
