<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified',])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // File Upload Route for Admins only
    Route::middleware('role:admin')->post('/file-upload', [FileController::class, 'store'])->name('file.upload');
    // File Download Route for all authenticated users
    Route::get('/file-download/{fileName}', [FileController::class, 'download'])->name('file.download');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';