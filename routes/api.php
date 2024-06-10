<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Controllers\Controller;


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::get('/',[Controller::class, 'ApiHome']);


Route::middleware('auth:sanctum')->post('/todo/add', [TaskController::class, 'addTask'])->middleware(ApiKeyMiddleware::class);
Route::middleware('auth:sanctum')->post('/todo/status/{id}', [TaskController::class, 'updateStatus'])->middleware(ApiKeyMiddleware::class);
