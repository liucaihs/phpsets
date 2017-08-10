<?php

namespace App\Http\Middleware;

use Closure;
use Route,Log,Request ,URL;
class CheckLogin
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

        if (!$request->session()->get('admuser.id', false)) {
            return redirect('login');
        }
        return $next($request);
    }

}
