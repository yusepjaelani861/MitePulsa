<?php

use App\Http\Controllers\DigiflazzController;
use Illuminate\Support\Facades\Route;


Route::prefix('transaction')->group(function () {
    Route::get('/cek-saldo', [DigiflazzController::class, 'cek_saldo']);
    Route::get('/price-list', [DigiflazzController::class, 'daftar_harga']);
    Route::get('/cek-tagihan', [DigiflazzController::class, 'cek_tagihan']);
    Route::get('/inquiry-pln', [DigiflazzController::class, 'inquiry_pln']);

    Route::post('/topup', [DigiflazzController::class, 'topup']);
    Route::post('/bayar-tagihan', [DigiflazzController::class, 'bayar_tagihan']);
    Route::post('/webhook', [DigiflazzController::class, 'webhook']);
});