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
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
            Route::post('/verify/{id}', [App\Http\Controllers\Admin\UserController::class, 'verify'])->name('admin.users.verify');
            Route::get('/detail/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
        });

        Route::prefix('/asrama')->group(function () {
            Route::get('/putra', [App\Http\Controllers\Admin\RoomController::class, 'getAsramaPutra'])->name('admin.room.putra');
            Route::get('/putri', [App\Http\Controllers\Admin\RoomController::class, 'getAsramaPutri'])->name('admin.room.putri');
            Route::get('/putra/detail/{id}', [App\Http\Controllers\Admin\RoomController::class, 'showPutra'])->name('admin.room.putra.show');
            Route::get('/putri/detail/{id}', [App\Http\Controllers\Admin\RoomController::class, 'showPutri'])->name('admin.room.putri.show');
        });

        Route::prefix('/pengajuan-penghuni')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ResidencyController::class, 'index'])->name('admin.penghuni.index');
            Route::post('/accept/{id}', [App\Http\Controllers\Admin\ResidencyController::class, 'acceptApplyResidency'])->name('admin.penghuni.accept');
            Route::post('/reject/{id}', [App\Http\Controllers\Admin\ResidencyController::class, 'rejectApplyResidency'])->name('admin.penghuni.reject');
            Route::post('/verify-or-reject/{id}', [App\Http\Controllers\Admin\ResidencyController::class, 'verifyOrReject'])->name('admin.penghuni.verify-or-reject');
            Route::get('/detail/{id}', [App\Http\Controllers\Admin\ResidencyController::class, 'show'])->name('admin.penghuni.show');
        });

        Route::prefix('/perpanjangan')->group(function () {
           Route::get('/', [App\Http\Controllers\Admin\ExtensionController::class, 'index'])->name('admin.extension.index');
           Route::post('/accept/{id}', [App\Http\Controllers\Admin\ExtensionController::class, 'acceptPayment'])->name('admin.extension.accept');
           Route::post('/reject/{id}', [App\Http\Controllers\Admin\ExtensionController::class, 'rejectPayment'])->name('admin.extension.reject');
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
        Route::put('/update-pengajuan-penghuni', [App\Http\Controllers\User\ResidencyController::class, 'restoreApplyResidency'])->name('user.penghuni.update');
        Route::post('/upload-bukti-pembayaran', [App\Http\Controllers\User\ResidencyController::class, 'storePayment'])->name('user.penghuni.payment');
    });
});
