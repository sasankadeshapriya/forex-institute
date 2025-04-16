<?php

use App\Http\Controllers\EntrolledCourseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserDashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserDashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->post('/file-upload', [FileController::class, 'store'])->name('file.upload');
    Route::get('/file-download/{fileName}', [FileController::class, 'download'])->name('file.download');
    Route::get('/file-stream/{fileName}', [FileController::class, 'stream'])->name('file.stream');

    Route::resource('entrolled-courses', EntrolledCourseController::class);

    Route::get('tcontent', function () {
        return view('client.entrolled-courses.show');
    })->name('tcontent');

    Route::post('/entrolled-courses/{course}/mark-complete/{contentId}', [EntrolledCourseController::class, 'markContentComplete']);

});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';