<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\CourseContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::resource('courses', CourseController::class);

        Route::prefix('course-content')->group(function () {
            Route::get('create/{course_id}', [CourseContentController::class, 'create'])->name('course-content.create');
            Route::post('store/{course_id}', [CourseContentController::class, 'store'])->name('course-content.store');
            Route::get('edit/{id}', [CourseContentController::class, 'edit'])->name('course-content.edit');
            Route::put('update/{id}', [CourseContentController::class, 'update'])->name('course-content.update');
            Route::delete('destroy/{id}', [CourseContentController::class, 'destroy'])->name('course-content.destroy');
        });
    });