<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardlessTransactionController;
use App\Http\Controllers\BeneficiaryController;

Route::get('/', function () {
    return redirect('/user/login');
});



Route::resource('/news', NewsController::class)->only(['index', 'show']);


Route::get('/user/signup', [UsersController::class, 'create'])->name('signup');
Route::post('/user/signup', [UsersController::class, 'store'])->name('storeUser');
Route::get('/user/login', [UsersController::class, 'login'])->name('login');
Route::post('/user/login', [UsersController::class, 'storelogin'])->name('storelogin');
Route::post('/user/logout', [UsersController::class, 'logout'])->name('logout');

// Routes that needs Session Auth
Route::middleware('auth.session')->group(function () {


    Route::get('/user/home', function () {
        return (view('users.home'));
    })->name('home');
    Route::resource('/user', UsersController::class)->only(['show', 'edit', 'update', 'destroy']);
    Route::resource('/news', NewsController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('/beneficiaries', BeneficiaryController::class)->only(['index', 'create', 'store']);

    Route::get('/cardless/deposit', [CardlessTransactionController::class, 'showDeposit'])->name('cardless.deposit.form');
    Route::post('/cardless/deposit', [CardlessTransactionController::class, 'deposit'])->name('cardless.deposit');
 
    Route::get('/cardless/withdraw', [CardlessTransactionController::class, 'showWithdraw'])->name('cardless.withdraw.form');
    Route::post('/cardless/withdraw', [CardlessTransactionController::class, 'withdraw'])->name('cardless.withdraw');
 
    Route::get('/cardless/history', [CardlessTransactionController::class, 'history'])->name('cardless.history');
});