<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('anggota', AnggotaController::class);

    Route::resource('simpanan', SimpananController::class);

    Route::resource('users', UserController::class);

});