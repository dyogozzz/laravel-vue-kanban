<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create/task', [TaskController::class, 'create']);

Route::PUT('/edit/task/{id}', [TaskController::class, 'edit']);

Route::PUT('/edit/body/task/{id}', [TaskController::class, 'editTaskFull']);

Route::get('/tasks/all', [TaskController::class, 'AllTasks']);

Route::get('/users', [ProfileController::class, 'AllUsers']);

Route::delete('/delete/task/{id}', [TaskController::class, 'deleteTask']);