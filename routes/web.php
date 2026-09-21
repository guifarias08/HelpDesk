<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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
