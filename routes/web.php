<?php

use App\Http\Controllers\{AnswerController, UserController, AuthController, TicketController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->middleware(['auth', 'admin'])->group(function(){
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::put('/users/{user}', 'update')->name('users.update');
    Route::get('/users/{user}', 'show')->name('users.show');
    Route::delete('/users/{user}', 'destroy')->name('users.destroy');
});

Route::controller(AuthController::class)->middleware('guest')->group(function(){
    Route::get('/login', 'create')->name('auth.create');
    Route::post('/login', 'store')->name('auth.store');
});

Route::controller(AuthController::class)->middleware('auth')->group(function(){
    Route::delete('/logout', 'destroy')->name('auth.destroy');
});

Route::controller(TicketController::class)->middleware('auth')->group(function(){
    Route::get('/tickets', 'index')->name('tickets.index');
    Route::get('/tickets/{ticket}', 'show')->name('tickets.show');
    Route::post('/tickets', 'store')->name('tickets.store');
    Route::delete('/tickets/{ticket}', 'destroy')->name('tickets.destroy');
    Route::put('/tickets/{ticket}', 'update')->name('tickets.update');
    Route::get('/tickets/{ticket}/edit', 'edit')->name('tickets.edit');
});

Route::controller(AnswerController::class)->middleware('auth')->group(function(){
    Route::post('/tickets/{ticket}/answers', 'store')->name('answers.store');
});

Route::get('/', function() {
    if (Auth::check()) return to_route('tickets.index');
    return to_route('auth.create');
});