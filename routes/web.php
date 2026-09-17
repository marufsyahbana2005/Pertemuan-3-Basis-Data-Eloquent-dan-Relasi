<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

// Rute halaman utama bawaan
Route::get('/', function () {
    return view('welcome');
});

// Rute modul tiket
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{ticket}', [TicketController::class, 'show'])
    ->whereNumber('ticket')
    ->name('tickets.show');
Route::get('/api/tickets/{ticket}', [TicketController::class, 'showJson'])
    ->whereNumber('ticket')
    ->name('tickets.show-json');