<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('todos.index');
    })->name('home');

    Route::delete('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('login.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login.create');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});
