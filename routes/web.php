<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\Web\WebController;

use App\Http\Controllers\Web\PendaftaranController;
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('master-data')->group(function () {
        Route::get('/project', [WebController::class, 'Project'])->name('master-data.project');
    });

    Route::prefix('control')->group(function () {
    });
});

require __DIR__.'/auth.php';
