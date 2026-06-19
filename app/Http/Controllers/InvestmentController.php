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
    private function getAccount(int $userId): ?Account
    {
        $account = Account::where('user_id', $userId)
        ->where('account_type_id', 2)
        ->first();
 
        return $account;
    }

    private function getInvestmentBalance(int $userId): float
    {
        $totalInvested = Investment::where('user_id', $userId)
            ->where('type', 'invest')
            ->where('status', 'completed')
            ->sum('amount');

        $totalLiquidated = Investment::where('user_id', $userId)
            ->where('type', 'liquidate')
            ->where('status', 'completed')
            ->sum('amount');

        return (float) ($totalInvested - $totalLiquidated);
    }

    public function showLiquidate(Request $request)
    {
        $userId  = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        if (!$account) {
            return redirect()->route('home')->with('success', "Error: Haven't created investment account!");
        }
        
        $investmentBalance = $this->getInvestmentBalance($userId);

        return view('investments.liquidate', compact('user', 'account', 'investmentBalance'));
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

        $investmentBalance = $this->getInvestmentBalance($userId);

        if ($investmentBalance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

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

        $investmentBalance = $this->getInvestmentBalance($userId);

        return view('investments.liquidate', compact('user', 'account', 'investmentBalance'));
    }

    public function showInvest(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        if (!$account) {
            return redirect()->route('home')->with('success', "Error: Haven't created investment account!");
        }

        $investmentBalance = $this->getInvestmentBalance($userId);

        return view('investments.invest', compact('user', 'account', 'investmentBalance'));
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
            $investAmount = $validated['amount'] + $validated['amount'] * 0.01;

            // Log the investment transaction
            Investment::create([
                'user_id' => $userId,
                'amount' => $investAmount,
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

        $investmentBalance = $this->getInvestmentBalance($userId);

        return view('investments.invest', compact('user', 'account', 'investmentBalance'));
    }

    public function history(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

        if (!$account) {
            return redirect()->route('home')->with('success', "Error: Haven't created investment account!");
        }

        $transactions = Investment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $investmentBalance = $this->getInvestmentBalance($userId);

        return view('investments.history', compact('user', 'account', 'transactions', 'investmentBalance'));
    }
}