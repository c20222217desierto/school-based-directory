<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the user login form.
     */
    public function showUserLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }
    
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.admin'); // Redirect admins if they try to access user login
        }
    
        return view('auth.user.login');
    }

    /**
     * Handle user login.
     */
    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ensure the admin is logged out before logging in a user
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate(); // Secure the session
            return redirect()->route('user.dashboard'); // Redirect to user dashboard
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Handle user logout.
     */
    public function userLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect to login page
    }

    /**
     * Show the admin login form.
     */
   
    /**
     * Handle admin login.
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ensure the user is logged out before logging in an admin
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate(); // Secure the session
            return redirect()->route('admin.admin'); // Redirect to admin dashboard
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Handle admin logout.
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect('/');
        // Redirect to admin login page
    }
}
