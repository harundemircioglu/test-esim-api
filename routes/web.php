<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/get-countries', [CountryController::class, 'getCountries'])->name('getCountries');
Route::get('/get-country-coverages/{countryCode}', [CountryController::class, 'getCountryCoverages'])->name('getCountryCoverages');
