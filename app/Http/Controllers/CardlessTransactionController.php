<?php

namespace App\Http\Controllers;

use App\Models\Cardless;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

class CardlessTransactionController extends Controller
{
    private function getAccount(int $userId): Account
    {
        $account = Account::where('user_id', $userId)
        ->where('account_type_id', 1)
        ->firstOrFail();
 
        if ($account->status !== 'active') {
            abort(403, 'Your account is not active.');
        }
 
        return $account;
    }

    public function showDeposit(Request $request)
    {
        $userId  = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        return view('cardless.deposit', compact('user', 'account'));
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

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
        });

        return view('cardless.deposit', compact('user', 'account'));
    }

    public function showWithdraw(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        return view('cardless.withdraw', compact('user', 'account'));
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account= $this->getAccount($userId);

        if ($account->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
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
        });

        return view('cardless.withdraw', compact('user', 'account'));
    }

    public function history(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $account = $this->getAccount($userId);

        $transactions = Cardless::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cardless.history', compact('user', 'account', 'transactions'));
    }
}