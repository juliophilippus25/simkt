<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route login dan register
Route::middleware('redirectIfAuthenticated')->group(function () {
    Route::get('register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('showRegister');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('showLogin');
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
});

// Route terproteksi
Route::middleware(['redirectIfNotAuthenticated', 'accessControl'])->group(function () {
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    // Route Admin
    Route::prefix('/admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('/penghuni')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
            Route::post('/verify/{id}', [App\Http\Controllers\Admin\UserController::class, 'verify'])->name('admin.users.verify');
        });

        Route::prefix('/pengajuan-penghuni')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ResidencyController::class, 'index'])->name('admin.pengajuan');
            Route::post('/accept/{id}', [App\Http\Controllers\Admin\ResidencyController::class, 'acceptApplyResidency'])->name('admin.pengajuan.accept');
            Route::post('/reject/{id}', [App\Http\Controllers\Admin\ResidencyController::class, 'rejectApplyResidency'])->name('admin.pengajuan.reject');
        });
    });

    // Route User
    Route::prefix('/user')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
        Route::get('/profil', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('user.profile');
        Route::post('/update-biodata', [App\Http\Controllers\User\ProfileController::class, 'updateBiodata'])->name('user.biodata.update');
        Route::post('/update-berkas', [App\Http\Controllers\User\ProfileController::class, 'updateBerkas'])->name('user.berkas.update');
        Route::put('/update-password', [App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('user.password.update');
        Route::get('/penghuni', [App\Http\Controllers\User\ResidencyController::class, 'index'])->name('user.penghuni');
        Route::post('/pengajuan-penghuni', [App\Http\Controllers\User\ResidencyController::class, 'storeApplyResidency'])->name('user.penghuni.apply');
    });
});
