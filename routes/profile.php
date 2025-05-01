<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Role-specific profile updates
    Route::patch('/profile/student', [ProfileController::class, 'updateStudent'])
        ->name('profile.student.update');
    Route::patch('/profile/employer', [ProfileController::class, 'updateEmployer'])
        ->name('profile.employer.update');
});
