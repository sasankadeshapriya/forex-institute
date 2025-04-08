<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])
            ->name('dashboard');
        Route::resource('courses', CourseController::class);
    });