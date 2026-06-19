<?php

namespace App\Http\Controllers;

use App\Models\Cardless;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CardlessTransactionController extends Controller
{
    private function getAccount(int $userId): ?Account
    {
        $account = Account::where('user_id', $userId)
            ->where('account_type_id', 1)
            ->first();

        return $account;
    }

    public function showDeposit(Request $request)
    {
        $userId  = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

        if (!$account) {
            return redirect()->route('home')->with('error', "Error: Haven't created savings account!");
        }

        return view('cardless.deposit', compact('user', 'account'));
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'pin' => 'required|digits:6'
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

        if (!Hash::check($validated['pin'], $account->pin)) {
            return back()
                ->withErrors(['pin' => 'Incorrect PIN.'])
                ->withInput($request->except('pin'));
        }

        DB::transaction(function () use ($account, $userId, $validated) {
            // Update the real account balance
            $account->balance += $validated['amount'];
            $account->save();

            // Log the cardless transaction
            Cardless::create([
                'user_id' => $userId,
                'amount' => $validated['amount'],
                'type' => 'deposit',
                'status' => 'completed',
                'date' => now()->toDateString(),
            ]);

            $transaction = Transaction::create([
                'sender_account_number' => $account->account_number,
                'receiver_account_number' => null,
                'amount' => $validated['amount'],
                'type' => 'deposit',
                'status' => 'success',
                'description' => 'Cardless Deposit',
            ]);
        });

        return view('cardless.deposit', compact('user', 'account'));
    }

    public function showWithdraw(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

        if (!$account) {
            return redirect()->route('home')->with('error', "Error: Haven't created savings account!");
        }

        return view('cardless.withdraw', compact('user', 'account'));
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'pin' => 'required|digits:6'
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

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

            // Log the cardless transaction
            Cardless::create([
                'user_id' => $userId,
                'amount' => $validated['amount'],
                'type' => 'withdrawal',
                'status' => 'completed',
                'date' => now()->toDateString(),
            ]);

            $transaction = Transaction::create([
                'sender_account_number' => $account->account_number,
                'receiver_account_number' => null,
                'amount' => $validated['amount'],
                'type' => 'withdraw',
                'status' => 'success',
                'description' => 'Cardless Withdrawal',
            ]);
        });

        return view('cardless.withdraw', compact('user', 'account'));
    }

    public function history(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

        if (!$account) {
            return redirect()->route('home')->with('error', "Error: Haven't created savings account!");
        }

        $transactions = Cardless::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cardless.history', compact('user', 'account', 'transactions'));
    }
}
