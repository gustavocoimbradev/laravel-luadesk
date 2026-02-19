<?php

use App\Http\Controllers\{UserController, AuthController, TicketController};

use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function(){
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::put('/users/{user}', 'update')->name('users.update');
    Route::get('/users/{user}', 'show')->name('users.show');
    Route::delete('/users/{user}', 'destroy')->name('users.destroy');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/auth', 'index')->name('auth.index');
    Route::post('/auth', 'store')->name('auth.store');
    Route::delete('/auth', 'destroy')->name('auth.destroy');
});

Route::controller(TicketController::class)->group(function(){
    Route::get('/tickets', 'index')->name('tickets.index');
    Route::get('/tickets/{ticket}', 'show')->name('tickets.show');
    Route::post('/tickets', 'store')->name('tickets.store');
    Route::delete('/tickets/{ticket}', 'destroy')->name('tickets.destroy');
    Route::put('/tickets/{ticket}', 'update')->name('tickets.update');
    Route::get('/tickets/{ticket}/edit', 'edit')->name('tickets.edit');
});