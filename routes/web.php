<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketCommentController;

Route::resource('tickets', TicketController::class);
Route::get('/', function () {
    return redirect()->route('dashboard');
});
 
Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->name('dashboard');

Route::resource(
    'tickets',
    TicketController::class
);

Route::post(
    '/tickets/{ticket}/comments',
    [TicketCommentController::class, 'store']
)->name('tickets.comments.store');

Route::resource(
    'categories',
    CategoryController::class
)->except(['show']);