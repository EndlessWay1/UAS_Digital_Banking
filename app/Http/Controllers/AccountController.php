<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $userId = $this->getLoggedInUserId($request);

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
        $userId = $this->getLoggedInUserId($request);

        $validated = $request->validate([
            'account_type_id' => [
                'required',
                Rule::exists('account_types', 'id'),
            ],
            'initial_balance' => [
                'required',
                'numeric',
                'min:0',
            ],
            'pin' => [
                'required',
                'digits:6',
                'confirmed',
            ],
        ]);

        $accountType = AccountType::findOrFail($validated['account_type_id']);

        $alreadyHasAccountType = Account::where('user_id', $userId)
            ->where('account_type_id', $accountType->id)
            ->exists();

        if ($alreadyHasAccountType) {
            throw ValidationException::withMessages([
                'account_type_id' => 'You already have an account with this account type.',
            ]);
        }

        if ((float) $validated['initial_balance'] < (float) $accountType->minimum_balance) {
            throw ValidationException::withMessages([
                'initial_balance' => 'Initial balance must be at least Rp ' . number_format($accountType->minimum_balance, 0, ',', '.') . ' for ' . $accountType->name . ' account.',
            ]);
        }

        $account = Account::create([
            'user_id' => $userId,
            'account_type_id' => $accountType->id,
            'account_number' => $this->generateAccountNumber(),
            'balance' => $validated['initial_balance'],
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
        if ($account->user_id !== $this->getLoggedInUserId($request)) {
            abort(403, 'Unauthorized account access.');
        }
    }

    private function getLoggedInUserId(Request $request): int
    {
        $userId = $request->session()->get('id');

        if (!$userId) {
            abort(401, 'Please login first.');
        }

        return (int) $userId;
    }

    private function generateAccountNumber(): string
    {
        do {
            $number = (string) random_int(1000000000, 9999999999);
        } while (Account::where('account_number', $number)->exists());

        return $number;
    }
}