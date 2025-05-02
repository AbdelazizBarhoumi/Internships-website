<?php
use App\Http\Controllers\InternshipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [InternshipController::class, 'index'])->name('home');
Route::get('/search', SearchController::class);
Route::get('/tags/{tagName}', TagController::class)->name('tags.show');
// Authentication required routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->isEmployer()) {
            return redirect()->route('employer.dashboard');
        } else {
            // For student/default dashboard
            return view('dashboard');
        }
    })->name('dashboard');
});

// Add these routes to your routes file



// Include other route files
require __DIR__ . '/application.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/internship.php';

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::post('/users/{user}/promote', [AdminController::class, 'promote'])->name('admin.promote');
    Route::post('/users/{user}/demote', [AdminController::class, 'demote'])->name('admin.demote');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');

    // Internship management
    Route::get('/internships', [AdminController::class, 'internships'])->name('admin.internships');
    Route::get('/internships/{internship}', [AdminController::class, 'showInternship'])->name('admin.internships.show');
   Route::delete('/internships/{internship}', [AdminController::class, 'deleteInternship'])->name('admin.internships.delete');

    // Application management
    Route::get('/applications', [AdminController::class, 'applications'])->name('admin.applications');
    Route::get('/applications/{application}', [AdminController::class, 'showApplication'])->name('admin.applications.show');
    Route::post('/applications/{application}/status', [AdminController::class, 'updateApplicationStatus'])->name('admin.applications.update-status');

    // System settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Add this route
    Route::get('/account/suspended', [App\Http\Controllers\AccountController::class, 'suspended'])
        ->name('account.suspended');

    // Optional contact support route
    Route::post('/account/contact-support', [App\Http\Controllers\AccountController::class, 'contactSupport'])
        ->name('account.contact-support');

    // Add these routes with the existing suspension route
    Route::get('/account/suspended', [App\Http\Controllers\AccountController::class, 'suspended'])
        ->name('account.suspended');

Route::post('/account/appeal', [App\Http\Controllers\AccountController::class, 'submitAppeal'])->name('account.appeal');
});

Route::middleware(['auth', 'can:employer'])->group(function () {
    Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
    Route::post('/internships/{internship}/toggle-status', [EmployerController::class, 'toggleInternshipStatus'])->name('myinternship.active');

});

Route::fallback(function() {
    abort(404);
});


//test route

Route::get('/test', function () {
    return view('test');
});