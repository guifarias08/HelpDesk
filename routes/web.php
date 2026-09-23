<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

});


/*
|--------------------------------------------------------------------------
| Rotas para visitantes
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Rotas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Chamados
    |--------------------------------------------------------------------------
    */

    Route::get('/tickets/board', [
        TicketController::class,
        'board'
    ])->name('tickets.board');


    Route::post('/tickets/{ticket}/comments', [
        TicketCommentController::class,
        'store'
    ])->name('tickets.comments.store');


    Route::resource('tickets', TicketController::class)
        ->except(['edit']);


    /*
    |--------------------------------------------------------------------------
    | Categorias
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', CategoryController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthenticatedSessionController::class,
        'destroy'
    ])->name('logout');

});