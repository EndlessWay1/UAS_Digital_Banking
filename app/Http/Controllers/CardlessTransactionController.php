<?php

namespace App\Http\Controllers;

use App\Models\Cardless;
use App\Models\User;
use Illuminate\Http\Request;

class CardlessTransactionController extends Controller
{
    private function getBalance(int $userId): float
    {
        $deposits = Cardless::where('user_id', $userId)
            ->where('type', 'deposit')
            ->where('status', 'completed')
            ->sum('amount');

        $withdrawals = Cardless::where('user_id', $userId)
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('amount');

        return (float) ($deposits - $withdrawals);
    }

    public function showDeposit(Request $request)
    {
        $userId  = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $balance = $this->getBalance($userId);

        return view('cardless.deposit', compact('user', 'balance'));
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);

        Cardless::create([
            'user_id' => $userId,
            'amount' => $validated['amount'],
            'type' => 'deposit',
            'status' => 'completed',
            'date' => now()->toDateString(),
        ]);

        $balance = $this->getBalance($userId);

        return view('cardless.deposit', compact('user', 'balance'));
    }

    public function showWithdraw(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $balance = $this->getBalance($userId);

        return view('cardless.withdraw', compact('user', 'balance'));
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        $balance = $this->getBalance($userId);

        Cardless::create([
            'user_id' => $userId,
            'amount' => $validated['amount'],
            'type' => 'withdrawal',
            'status' => 'completed',
            'date' => now()->toDateString(),
        ]);

        $balance = $this->getBalance($userId);

        return view('cardless.withdraw', compact('user', 'balance'));
    }

    public function history(Request $request)
    {
        $userId = $request->session()->get('id');
        $user = User::findOrFail($userId);
        
        $balance = $this->getBalance($userId);
        $transactions = Cardless::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cardless.history', compact('user', 'balance', 'transactions'));
    }
}