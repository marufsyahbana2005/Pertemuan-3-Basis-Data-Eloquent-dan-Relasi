<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\TicketController;

// 1. Pola parameter rute (hanya menerima angka ID)
Route::pattern('ticket', '[0-9]+');

// 2. Rute resource tiket (mencakup index, create, store, show, edit, update, destroy)
Route::resource('tickets', TicketController::class);

// 3. Rute pengujian kueri benchmark (menghasilkan JSON pengukuran)
Route::get('/benchmark', function () {
    // A: baseline lazy loading
    DB::enableQueryLog();
    DB::flushQueryLog();
    $rows = \App\Models\Ticket::orderByDesc('id')->paginate(10);
    foreach ($rows as $row) {
        $names = [$row->user->name, $row->category->name];
    }
    $lazy = DB::getQueryLog();

    // B: eager loading
    DB::flushQueryLog();
    $rows = \App\Models\Ticket::with(['user', 'category'])->orderByDesc('id')->paginate(10);
    foreach ($rows as $row) {
        $names = [$row->user->name, $row->category->name];
    }
    $eager = DB::getQueryLog();

    DB::disableQueryLog();

    return response()->json([
        'jumlah_query_lazy' => count($lazy),
        'jumlah_query_eager' => count($eager),
        'detail_query_eager' => array_column($eager, 'query'),
    ]);
});