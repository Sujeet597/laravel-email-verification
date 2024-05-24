<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes(['verify' => true]);

// Home route with email verification middleware
Route::middleware(['auth', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');