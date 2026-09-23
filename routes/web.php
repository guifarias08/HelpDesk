<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/tickets/board', [TicketController::class, 'board'])->name('tickets.board');
Route::post('/tickets/{ticket}/comments', [TicketCommentController::class, 'store'])
    ->name('tickets.comments.store');
Route::resource('tickets', TicketController::class)->except(['edit']);
Route::resource('categories', CategoryController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::middleware('guest')->group(function () {

    Route::get('/login', [
        AuthenticatedSessionController::class,
        'create'
    ])->name('login');

    Route::post('/login', [
        AuthenticatedSessionController::class,
        'store'
    ])->name('login.store');

});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {

        return view('dashboard');

    })->name('dashboard');


    Route::post('/logout', [
        AuthenticatedSessionController::class,
        'destroy'
    ])->name('logout');

});