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
});

Route::resource('/news', NewsController::class)->only(['index', 'show']);
