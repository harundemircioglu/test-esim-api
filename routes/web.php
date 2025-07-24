<?php

use App\Http\Controllers\EsimController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('check.sale');
Route::post('/create-esim', [EsimController::class, 'createESim'])->name('createESim');
Route::get('/sale', [SaleController::class, 'index'])->name('sale.index')->middleware('check.confirm');
Route::get('/confirm', [SaleController::class, 'confirm'])->name('sale.confirm')->middleware('check.sold.data');
Route::post('/confirm-sale', [SaleController::class, 'confirmSale'])->name('sale.confirmSale');
