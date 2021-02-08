<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

class SentinelAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //$action = $request->route()->getName();

        if(Sentinel::check())
        {
            // if (Sentinel::hasAccess($action))
            // {
                return $next($request);
            // }
        }

        $notification = ['message'=>"please login.",'type'=>'danger'];
        return redirect()->route('backend.user.login')->with($notification);
    }
}
