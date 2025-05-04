<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::resource('courses', CourseController::class);

        Route::resource('orders', OrderController::class);

        Route::prefix('course-content')->group(function () {
            Route::get('create/{course_id}', [CourseContentController::class, 'create'])->name('course-content.create');
            Route::post('store/{course_id}', [CourseContentController::class, 'store'])->name('course-content.store');
            Route::get('edit/{id}', [CourseContentController::class, 'edit'])->name('course-content.edit');
            Route::put('update/{id}', [CourseContentController::class, 'update'])->name('course-content.update');
            Route::delete('destroy/{id}', [CourseContentController::class, 'destroy'])->name('course-content.destroy');
            Route::delete('delete-all/{course_id}', [CourseContentController::class, 'deleteAll'])->name('course-content.deleteAll');
            Route::get('move-up/{id}', [CourseContentController::class, 'moveUp'])->name('course-content.moveUp');
            Route::get('move-down/{id}', [CourseContentController::class, 'moveDown'])->name('course-content.moveDown');
        });
    });

Route::get('admin/debug/slip/{filename}', function ($filename) {
    $filePath = storage_path('app/private/slips/' . $filename);
    return response()->file($filePath);
})->name('admin.debug.slip')->middleware(['auth', 'role:admin']);

