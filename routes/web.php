<?php

use App\Http\Controllers\ClientOrderList;
use App\Http\Controllers\EntrolledCourseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserDashboard;
use App\Http\Controllers\CourseListController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [UserDashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// shop related routes
Route::get('/courses', [CourseListController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseListController::class, 'show'])->name('courses.show');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('add/{course}', [CartController::class, 'add'])->name('add');
    Route::post('remove/{course}', [CartController::class, 'remove'])->name('remove');
    Route::post('clear', [CartController::class, 'clear'])->name('clear');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->post('/file-upload', [FileController::class, 'store'])->name('file.upload');
    Route::get('/file-download/{fileName}', [FileController::class, 'download'])->name('file.download');
    Route::get('/file-stream/{fileName}', [FileController::class, 'stream'])->name('file.stream');

    Route::resource('entrolled-courses', EntrolledCourseController::class);

    Route::post(
        '/entrolled-courses/{entrolled_course}/mark-complete/{contentId}',
        [EntrolledCourseController::class, 'markComplete']
    )->name('entrolled-courses.mark-complete');

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'show'])->name('index');
        Route::post('process', [CheckoutController::class, 'processOrder'])->name('process');
        Route::get('success', [CheckoutController::class, 'success'])->name('success');
    });

    Route::get('/order-list', [ClientOrderList::class, 'index'])->name('order-list.index');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';