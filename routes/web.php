<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [App\Http\Controllers\User\AuthController::class, 'showRegister'])->name('showRegister');
Route::post('register', [App\Http\Controllers\User\AuthController::class, 'register'])->name('register');
