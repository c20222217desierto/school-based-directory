<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;
use Filament\Http\Controllers\Auth\LoginController as FilamentLoginController;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * @var string
     */
    public const HOME = '/dashboard'; // Default redirect for users


public function boot(): void
{
    $this->routes(function () {
        // Web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // API routes
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // ✅ Filament routes (register default Filament admin routes)
    
      

    });
}


    /**
     * Configure rate limiting for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
   
}
