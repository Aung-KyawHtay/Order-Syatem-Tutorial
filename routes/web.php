<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/items', [ItemController::class, 'index'])
        ->name('items.index');

    Route::get('/items/create', [ItemController::class, 'create'])
        ->name('items.create');

    Route::post('/items', [ItemController::class, 'store'])
        ->name('items.store');

    Route::get('/items/{id}/edit', [ItemController::class, 'edit'])
        ->name('items.edit');

    Route::put('/items/{id}', [ItemController::class, 'update'])
        ->name('items.update');

    Route::delete('/items/{id}', [ItemController::class, 'destroy'])
        ->name('items.destroy');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/create', [OrderController::class, 'create'])
        ->name('orders.create');

    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');

    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])
        ->whereNumber('id')
        ->name('orders.edit');

    Route::put('/orders/{id}', [OrderController::class, 'update'])
        ->whereNumber('id')
        ->name('orders.update');

    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])
        ->whereNumber('id')
        ->name('orders.destroy');

    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->whereNumber('id')
        ->name('orders.show');
});
