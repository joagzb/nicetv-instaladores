<?php

namespace App\Http\Middleware;

use App\Models\admin;
use Closure;
use Illuminate\Http\Request;

class adminlvl2
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
        if(admin::find(auth()->user()->id)->nivel<2) {
            return redirect()->route('showHomeAdmin');
        }

        return $next($request);
    }
}
