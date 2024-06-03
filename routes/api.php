<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\ApiKeyMiddleware;


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->post('/todo/add', [TaskController::class, 'addTask'])->middleware(ApiKeyMiddleware::class);
Route::middleware('auth:sanctum')->post('/todo/status', [TaskController::class, 'updateStatus'])->middleware(ApiKeyMiddleware::class);