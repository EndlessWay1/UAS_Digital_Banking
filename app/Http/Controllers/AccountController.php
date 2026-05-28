<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->session()->get('id');

        $accounts = Account::with('accountType')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        $accountTypes = AccountType::orderBy('name')->get();

        return view('accounts.create', compact('accountTypes'));
    }

    public function store(Request $request)
    {
        $userId = $request->session()->get('id');

        $validated = $request->validate([
            'account_type_id' => [
                'required',
                Rule::exists('account_types', 'id'),
            ],
            'pin' => [
                'required',
                'digits:6',
                'confirmed',
            ],
        ]);

        $account = Account::create([
            'user_id' => $userId,
            'account_type_id' => $validated['account_type_id'],
            'account_number' => $this->generateAccountNumber(),
            'balance' => 0,
            'status' => 'active',
            'pin' => Hash::make($validated['pin']),
        ]);

        return redirect()
            ->route('accounts.show', $account)
            ->with('success', 'Account created successfully.');
    }

    public function show(Request $request, Account $account)
    {
        $this->authorizeAccountOwner($request, $account);

        $account->load('accountType', 'user');

        return view('accounts.show', compact('account'));
    }

    public function balance(Request $request, Account $account)
    {
        $this->authorizeAccountOwner($request, $account);

        $account->load('accountType');

        return view('accounts.balance', compact('account'));
    }

    private function authorizeAccountOwner(Request $request, Account $account): void
    {
        if ($account->user_id !== $request->session()->get('id')) {
            abort(403, 'Unauthorized account access.');
        }
    }

    private function generateAccountNumber(): string
    {
        do {
            $number = (string) random_int(1000000000, 9999999999);
        } while (Account::where('account_number', $number)->exists());

        return $number;
    }
}