<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationFileController;
Route::middleware(['auth'])->group(function () {
Route::get('/internship/{internship}/apply', [ApplicationController::class, 'create'])
        ->name('applications.create');
    Route::post('/internship/{internship}/apply', [ApplicationController::class, 'store'])
        ->name('applications.store');
});

// Application document download routes
Route::middleware(['auth', 'can:employer'])->group(function () {
    Route::get('/applications/{application}/download/{type}', [ApplicationFileController::class, 'download'])
        ->name('applications.download');
        Route::patch('dashboard/applications/{application}/notes', [ApplicationController::class, 'updateNotes'])
    ->name('applications.update-notes');
    Route::patch('dashboard/applications/{application}/status', [ApplicationController::class, 'updateStatus'])
    ->name('applications.update-status');
});

    // Application management (admin/employer only)
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard/applications', [ApplicationController::class, 'index'])
        ->name('applications.index');
    Route::get('dashboard/applications/{application}', [ApplicationController::class, 'show'])
        ->name('applications.show');

});




