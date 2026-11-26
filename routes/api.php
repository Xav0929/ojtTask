<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->name('api.')->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

    Route::patch('tasks/done-all', [TaskController::class, 'markAll'])->name('tasks.doneAll');
    Route::patch('tasks/{task}/done', [TaskController::class, 'toggle'])->name('tasks.done');
    Route::apiResource('tasks', TaskController::class);
});