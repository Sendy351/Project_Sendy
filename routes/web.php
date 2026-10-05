<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/tasks/{task}/claim', [TaskController::class, 'claim'])->name('tasks.claim');
Route::post('/tasks/{task}/proof', [TaskController::class, 'submitProof'])->name('tasks.proof');
Route::post('/tasks/{task}/complete', [TaskController::class, 'confirmComplete'])->name('tasks.complete');
Route::post('/switch-user', [TaskController::class, 'switchUser'])->name('tasks.switch_user');