<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrototypeController;
use App\Http\Controllers\SaleTransactionController;
use App\Http\Controllers\TipeController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

// AUTH (guest)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/signin', [AuthController::class, 'signin'])
    ->middleware('throttle:5,1')
    ->name('signin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [PrototypeController::class, 'dashboard'])->name('dashboard');

    // MASTER DATA — Tipe Rumah
    Route::get('/tipe', [TipeController::class, 'index'])->name('tipe.index');
    Route::post('/tipe', [TipeController::class, 'store'])->name('tipe.store');
    Route::put('/tipe/{tipe}', [TipeController::class, 'update'])->name('tipe.update');
    Route::delete('/tipe/{tipe}', [TipeController::class, 'destroy'])->name('tipe.destroy');

    // MASTER DATA — Unit
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/{unit}', [UnitController::class, 'show'])->name('units.show');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');

    // MASTER DATA — Pembeli
    Route::get('/buyers', [BuyerController::class, 'index'])->name('buyers.index');
    Route::post('/buyers', [BuyerController::class, 'store'])->name('buyers.store');
    Route::put('/buyers/{buyer}', [BuyerController::class, 'update'])->name('buyers.update');
    Route::delete('/buyers/{buyer}', [BuyerController::class, 'destroy'])->name('buyers.destroy');

    // PENJUALAN & TRACKING — pipeline state machine (PRD §6)
    Route::get('/pipeline', [SaleTransactionController::class, 'index'])->name('pipeline.index');
    Route::post('/transactions', [SaleTransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [SaleTransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/advance', [SaleTransactionController::class, 'advance'])->name('transactions.advance');
    Route::post('/transactions/{transaction}/cancel', [SaleTransactionController::class, 'cancel'])->name('transactions.cancel');

    // KEUANGAN — Invoice & Pembayaran
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    // KEUANGAN — Pencatatan Kas (cash basis)
    Route::get('/kas', [CashController::class, 'index'])->name('kas.index');
    Route::post('/kas', [CashController::class, 'store'])->name('kas.store');
    Route::delete('/kas/{cash}', [CashController::class, 'destroy'])->name('kas.destroy');
});
