<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * segun el tipo de usuario, redirigirlo a su sitio correspondiente
     *
     * @var string
     */
    static public function redirectTo() {
        $role = Auth::user()->type;
        $route = '/';
        switch ($role) {
            case 'admin':
                $route = '/admin/home';
                break;
            case 'instalador':
                $route = '/home';
                break;
        }
        return $route;
    }

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
     protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(function(){
                    require base_path('routes/web.php');
                    require base_path('routes/myRoutes/auth.routes.php');
                    require base_path('routes/myRoutes/common.routes.php');
                    require base_path('routes/myRoutes/instalador.routes.php');
                    require base_path('routes/myRoutes/admin.routes.php');
                });
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
