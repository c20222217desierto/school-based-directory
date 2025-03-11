<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomFilamentLogout
{
    public function handle($request, Closure $next)
    {
        if ($request->is('admin/logout')) {
            Auth::logout();
            return redirect()->route('/login'); // Redirect to your custom login route
        }

        return $next($request);
    }
}
