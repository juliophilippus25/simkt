<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('showRegister');
Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('showLogin');
Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::get('/test', function () {
    return view('layouts.content');
});
