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
Route::middleware(['auth'])->group(function () {
    Route::get('/applications/{application}/download/{type}', [ApplicationFileController::class, 'download'])
        ->name('applications.download');
    Route::patch('dashboard/applications/{application}/notes', [ApplicationController::class, 'updateNotes'])
        ->name('applications.update-notes');
    Route::patch('dashboard/applications/{application}/status', [ApplicationController::class, 'updateStatus'])
        ->name('applications.update-status');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard/applications', [ApplicationController::class, 'index'])
        ->name('applications.index');
    Route::get('dashboard/myapplications', [ApplicationController::class, 'myIndex'])
        ->name('applications.my.index');
    Route::get('dashboard/applications/{application}', [ApplicationController::class, 'show'])
        ->name('applications.show');
    Route::get('dashboard/applications/{application}/edit', [ApplicationController::class, 'edit'])
        ->name('applications.edit');
    Route::patch('dashboard/applications/{application}', [ApplicationController::class, 'update'])
        ->name('applications.update');
    Route::delete('dashboard/applications/{application}', [ApplicationController::class, 'destroy'])
        ->name('applications.destroy');
    

});




