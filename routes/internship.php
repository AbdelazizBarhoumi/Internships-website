<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InternshipController;

Route::get('internship/{internship}', [InternshipController::class, 'show'])->name('internship.show');
Route::middleware(['auth', 'can:employer'])->group(function () {

    Route::get('dashboard/internship/create', [InternshipController::class, 'create'])->name('internship.create');
    Route::post('dashboard/internship', [InternshipController::class, 'store'])->name('internship.store');

    Route::get('dashboard/myinternship/{internship}/edit', [InternshipController::class, 'edit'])->name('myinternship.edit');
    Route::patch('dashboard/myinternship/{internship}', [InternshipController::class, 'update'])->name('myinternship.update');
    Route::delete('dashboard/myinternship/{internship}', [InternshipController::class, 'destroy'])->name('myinternship.destroy');
    Route::get('dashboard/myInternships', [InternshipController::class, 'myInternships'])->name('myInternships');

});

Route::fallback(function() {
    abort(404);
});