<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

// Login
Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

// Logout
Route::post('logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// Register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


Route::get('/', function () {
    $active = 'home';
    return view('home', compact('active'));
})->name('home');


// Task
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth');
Route::get('/tasks/data', [TaskController::class, 'getTasksData'])->name('tasks.data')->middleware('auth');

// Motor History
Route::get('/motor', [HistoryController::class, 'index'])->name('motor.index')->middleware('auth');
Route::post('/motor/store', [HistoryController::class, 'store'])->name('motor.store')->middleware('auth');
