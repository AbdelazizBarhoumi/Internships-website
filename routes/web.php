<?php
use App\Http\Controllers\InternshipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;

// Public routes
Route::get('/', [InternshipController::class, 'index'])->name('home');
Route::get('/search', SearchController::class);
Route::get('/tags/{tag:name}', TagController::class);

// Authentication required routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Add these routes to your routes file



// Include other route files
require __DIR__.'/application.php';
require __DIR__.'/profile.php';
require __DIR__.'/auth.php';
require __DIR__.'/internship.php';
