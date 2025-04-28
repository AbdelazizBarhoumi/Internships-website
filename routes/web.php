<?php
use App\Http\Controllers\InternshipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [InternshipController::class, 'index'])->name('home');
Route::get('/search', SearchController::class);
Route::get('/tags/{tag:name}', TagController::class);

// Authentication required routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {         
               return redirect()->route('admin.dashboard');
        }
        else{
                    return view('dashboard');

        }
    })->name('dashboard');
});

// Add these routes to your routes file



// Include other route files
require __DIR__.'/application.php';
require __DIR__.'/profile.php';
require __DIR__.'/auth.php';
require __DIR__.'/internship.php';

// ...existing routes...

// Admin Routes
// ...existing routes...

// Admin Routes (using policy/gate authorization instead of middleware)
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/promote', [AdminController::class, 'promote'])->name('admin.promote');
    Route::post('/users/{user}/demote', [AdminController::class, 'demote'])->name('admin.demote');
});
