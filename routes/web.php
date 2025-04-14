<?php

use App\Http\Controllers\EntrolledCourseController;
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
    return view('client.dashboard');
})->middleware(['auth', 'verified',])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->post('/file-upload', [FileController::class, 'store'])->name('file.upload');
    Route::get('/file-download/{fileName}', [FileController::class, 'download'])->name('file.download');
    Route::get('/file-stream/{fileName}', [FileController::class, 'stream'])->name('file.stream');

    Route::resource('entrolled-courses', EntrolledCourseController::class);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';