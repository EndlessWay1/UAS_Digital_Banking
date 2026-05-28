<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardlessTransactionController;
use App\Http\Controllers\BeneficiaryController;

Route::get('/', function () {
    return redirect('/user/login');
});





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
    Route::get('/user/profile', [UsersController::class, 'show'])->name('profile');
    Route::get('/user/profile/edit', [UsersController::class, 'edit'])->name('profile.edit');
    Route::put('/user/profile/edit', [UsersController::class, 'update'])->name('profile.update');
    Route::get('/user/profile/remove', [UsersController::class, 'remove'])->name('profile.remove');
    Route::delete('/user/profile/remove', [UsersController::class, 'destroy'])->name('profile.delete');
    Route::resource('/news', NewsController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('/beneficiaries', BeneficiaryController::class)->only(['index', 'create', 'store']);

    Route::get('/cardless/deposit', [CardlessTransactionController::class, 'showDeposit'])->name('cardless.deposit.form');
    Route::post('/cardless/deposit', [CardlessTransactionController::class, 'deposit'])->name('cardless.deposit');

    Route::get('/cardless/withdraw', [CardlessTransactionController::class, 'showWithdraw'])->name('cardless.withdraw.form');
    Route::post('/cardless/withdraw', [CardlessTransactionController::class, 'withdraw'])->name('cardless.withdraw');

    Route::get('/cardless/history', [CardlessTransactionController::class, 'history'])->name('cardless.history');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/transfer', [TransactionController::class, 'transferForm'])->name('transactions.transfer.form');
    Route::post('/transactions/transfer', [TransactionController::class, 'transfer'])->name('transactions.transfer');
    Route::get('/transactions/deposit', [TransactionController::class, 'depositForm'])->name('transactions.deposit.form');
    Route::post('/transactions/deposit', [TransactionController::class, 'deposit'])->name('transactions.deposit');
    Route::get('/transactions/withdraw', [TransactionController::class, 'withdrawForm'])->name('transactions.withdraw.form');
    Route::post('/transactions/withdraw', [TransactionController::class, 'withdraw'])->name('transactions.withdraw');
    Route::get('/transactions/{id}/receipt', [TransactionController::class, 'receipt'])->name('transactions.receipt');
});
});

Route::resource('/news', NewsController::class)->only(['index', 'show']);
