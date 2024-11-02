<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route login dan register
Route::group([], function () {
    Route::get('register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('showRegister');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('showLogin');
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

// Route Admin
Route::prefix('/admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::post('/users/verify/{id}', [App\Http\Controllers\Admin\UserController::class, 'verify'])->name('admin.users.verify');
});

// Route User
Route::prefix('/user')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
});

Route::get('/test', function () {
    return view('layouts.content');
});
