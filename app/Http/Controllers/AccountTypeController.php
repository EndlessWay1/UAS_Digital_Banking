<?php

namespace App\Http\Controllers;

use App\Models\AccountType;

class AccountTypeController extends Controller
{
    public function index()
    {
        $accountTypes = AccountType::orderBy('name')->get();

        return view('account_types.index', compact('accountTypes'));
    }

    public function show(AccountType $accountType)
    {
        return view('account_types.show', compact('accountType'));
    }
}