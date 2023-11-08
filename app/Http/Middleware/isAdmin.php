<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if(auth()->check() && auth()->user()->role === "admin")
        // {
        //     return $next($request);
        // }
        // return  redirect()->route('loginform');

        if(Auth::guard('isAdmin')->check()){
        return $next($request);
      }
        return redirect('login')->with('error','You have not admin access');
    }
}
