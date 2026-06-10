<?php

use App\Http\Controllers\PrototypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PrototypeController::class, 'dashboard'])->name('dashboard');

Route::get('/units', [PrototypeController::class, 'units'])->name('units.index');
Route::get('/units/{code}', [PrototypeController::class, 'unit'])->name('units.show');

Route::get('/pipeline', [PrototypeController::class, 'pipeline'])->name('pipeline.index');
Route::get('/transactions/{id}', [PrototypeController::class, 'transaction'])->name('transactions.show');

Route::get('/invoices', [PrototypeController::class, 'invoices'])->name('invoices.index');

Route::get('/tipe', [PrototypeController::class, 'tipe'])->name('tipe.index');
