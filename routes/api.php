<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return 'Data User';
});

Route::get('/test', function () {
    return 'success connect';
});

// Autentikasi
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Task Management
Route::middleware('auth:sanctum')->resource('/tasks', TaskController::class);
Route::middleware('auth:sanctum')->delete('/tasks/delete/all', [TaskController::class, 'destroyAll']);
Route::middleware('auth:sanctum')->patch('/tasks/{task}/mark-complete', [TaskController::class, 'markAsComplete']);
Route::middleware('auth:sanctum')->patch('/tasks/complete/all', [TaskController::class, 'markAllAsComplete']);