<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        // ✅ Listen for user login & set "is_active" to true
        Event::listen(Login::class, function ($event) {
            if ($event->user) {
                $event->user->update(['is_active' => true]);
            }
        });

        // ✅ Listen for user logout & set "is_active" to false
        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                $event->user->update(['is_active' => false]);
            }
        });
    }

    public function handle(Request $request, \Closure $next)
{
    if (Auth::check() && !Auth::user()->is_active) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Your account is inactive.');
    }

    return $next($request);
}
}
