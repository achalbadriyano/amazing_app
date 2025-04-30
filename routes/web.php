<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $active = 'home';
    return view('home', compact('active'));
})->name('home');


// Task
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/data', [TaskController::class, 'getTasksData'])->name('tasks.data');

// Motor History
Route::get('/motor', [HistoryController::class, 'index'])->name('motor.index');
Route::post('/motor/store', [HistoryController::class, 'store'])->name('motor.store');
