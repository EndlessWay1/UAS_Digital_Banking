<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InvestmentController extends Controller
{
    private function getAccount(int $userId): Account
    {
        $account = Account::where('user_id', $userId)
        ->where('account_type_id', 2)
        ->firstOrFail();
 
        if ($account->status !== 'active') {
            abort(403, 'Your account is not active.');
        }
 
        return $account;
    }

    public function showLiquidate(Request $request)
    {
        $userId  = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        return view('investments.liquidate', compact('user', 'account'));
    }

    public function liquidate(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'pin' => 'required|digits:6'
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        if (!Hash::check($validated['pin'], $account->pin)) {
            return back()
                ->withErrors(['pin' => 'Incorrect PIN.'])
                ->withInput($request->except('pin'));
        }

        DB::transaction(function () use ($account, $userId, $validated) {
            // Update the real account balance
            $account->balance += $validated['amount'];
            $account->save();
 
            // Log the investment transaction
            Investment::create([
                'user_id' => $userId,
                'amount' => $validated['amount'],
                'type' => 'liquidate',
                'status' => 'completed',
                'date' => now()->toDateString(),
            ]);
        
            $transaction = Transaction::create([
                    'sender_account_number' => $account->account_number,
                    'receiver_account_number' => null,
                    'amount' => $validated['amount'],
                    'type' => 'deposit',
                    'status' => 'success',
                    'description' => 'Make liquidation',
            ]);
        });

        return view('investments.liquidate', compact('user', 'account'));
    }

    public function showInvest(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        return view('investments.invest', compact('user', 'account'));
    }

    public function invest(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'pin' => 'required|digits:6'
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        if ($account->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        if (!Hash::check($validated['pin'], $account->pin)) {
            return back()
                ->withErrors(['pin' => 'Incorrect PIN.'])
                ->withInput($request->except('pin'));
        }

        DB::transaction(function () use ($account, $userId, $validated) {
            // Update the real account balance
            $account->balance -= $validated['amount'];
            $account->save();
 
            // Log the investment transaction
            Investment::create([
                'user_id' => $userId,
                'amount' => $validated['amount'],
                'type' => 'invest',
                'status' => 'completed',
                'date' => now()->toDateString(),
            ]);

            $transaction = Transaction::create([
                'sender_account_number' => $account->account_number,
                'receiver_account_number' => null,
                'amount' => $validated['amount'],
                'type' => 'withdraw',
                'status' => 'success',
                'description' => 'Make liquidation',
            ]);
        });

        return view('investments.invest', compact('user', 'account'));
    }

    public function history(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

        $transactions = Investment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('investments.history', compact('user', 'account', 'transactions'));
    }
}