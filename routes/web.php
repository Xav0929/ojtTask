<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
Route::get('/', function () {
    return redirect()->route('tasks.index');
});
Route::patch('tasks/done-all', [TaskController::class, 'markAll'])->name('tasks.doneAll');
Route::patch('tasks/{task}/done', [TaskController::class, 'markDone'])->name('tasks.done');
Route::resource('tasks', TaskController::class)->except(['create']);
