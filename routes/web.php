<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardlessTransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/deposit', [CardlessTransactionController::class, 'deposit']);
Route::post('/deposit', [CardlessTransactionController::class, 'withdraw']);
