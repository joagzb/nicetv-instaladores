<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class tabPainter
{
    
    const paths = [
        'home', //instalador 0
        'historial', //instalador 1
        'help', //common 2
        'usuarios/administradores', //common 3
        'usuarios/self/profile/settings', //common 4
        'admin/instaladores', //admin  5
        'admin/home', //admin 6
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // pintar la navegacion lateral
        if (!Session::has('tabnav')) {
            Session::forget('tabnav');
            Session::push('tabnav', '');
        }
        
        foreach (self::paths as $path) {
            if (Str::contains($request->path(), $path)) {
                Session::put('tabnav', $path);
            }
        }
        
        return $next($request);
    }
}
