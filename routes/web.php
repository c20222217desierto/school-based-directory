<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use Filament\Http\Controllers\Auth\LoginController as FilamentLoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
*/

// Welcome Page
Route::get('/', fn () => view('welcome'));

// Shared Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Profile Management (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Dashboard (Role: user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// Admin Routes (Role: admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard (Handled by Filament)
    // Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Admin Login
    Route::get('/login', fn () => view('admin.login'))->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// General Dashboard (For Verified Users)
// Route::middleware('auth')->group(function () {
//     Route::get('/user/dashboard', fn () => view('/user/dashboard'))->name('user.dashboard');
// });




// Route::middleware(['user'])->group(function () {
//     Route::get('/user/dashboard', fn() => view('/user/dashboard'))->name('user.dashboard');
// });

// Admin Routes
// Route::middleware(['admin'])->group(function () {
//     Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
// });



Route::post('/admin/logout', function () {
    Auth::logout(); // Log out the user
    return redirect('/'); // Redirect to homepage
})->name('filament.admin.auth.logout');



// Route::middleware(['guest'])->group(function () {
//     Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
//         ->name('login');

//     Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
// });



require __DIR__.'/auth.php';
