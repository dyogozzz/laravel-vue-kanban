<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/products', function () {
    return view('products');
})->middleware(['auth', 'verified'])->name('products');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/create', function () {
    return view('create');
});

Route::post('/create/task', [TaskController::class, 'create']);

Route::PUT('/edit/task/{id}', [TaskController::class, 'edit']);

Route::PUT('/edit/body/task/{id}', [TaskController::class, 'editTaskFull']);

Route::get('/edit', function () {
    return view('edit');
});

Route::get('/tasks', [TaskController::class, 'AllTasks']);

Route::get('/tasks/{id}', [TaskController::class, 'tasks']);

Route::get('/users', [ProfileController::class, 'AllUsers']);

Route::delete('/delete/task/{id}', [TaskController::class, 'deleteTask']);
