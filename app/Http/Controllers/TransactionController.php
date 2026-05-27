<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\TransactionReceipt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrFail($request->session()->get('id'));
        $transactions = Transaction::where('sender_account_number', $user->account_number)
            ->orWhere('receiver_account_number', $user->account_number)
            ->latest()
            ->get();
        return view('transactions.index', compact('user', 'transactions'));
    }

    public function transferForm(Request $request)
    {
        $user = User::findOrFail($request->session()->get('id'));
        return view('transactions.transfer', compact('user'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'receiver_account_number' => 'required',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $sender = User::findOrFail($request->session()->get('id'));
        $receiver = User::where('account_number', $request->receiver_account_number)->first();

        if (!$receiver) {
            return back()->withErrors(['receiver_account_number' => 'Account number not found.']);
        }

        if ($sender->account_number === $request->receiver_account_number) {
            return back()->withErrors(['receiver_account_number' => 'You cannot transfer to your own account.']);
        }

        if ($sender->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        DB::transaction(function () use ($sender, $receiver, $request) {
            $sender->balance -= $request->amount;
            $receiver->balance += $request->amount;
            $sender->save();
            $receiver->save();

            $transaction = Transaction::create([
                'sender_account_number' => $sender->account_number,
                'receiver_account_number' => $receiver->account_number,
                'amount' => $request->amount,
                'type' => 'transfer',
                'status' => 'success',
                'description' => $request->description,
            ]);

            TransactionReceipt::create([
                'transaction_id' => $transaction->id,
                'receipt_number' => 'RCP-' . now()->format('Ymd') . '-' . str_pad($transaction->id, 4, '0', STR_PAD_LEFT),
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transfer successful!');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = User::findOrFail($request->session()->get('id'));

        DB::transaction(function () use ($user, $request) {
            $user->balance += $request->amount;
            $user->save();

            $transaction = Transaction::create([
                'sender_account_number' => $user->account_number,
                'receiver_account_number' => null,
                'amount' => $request->amount,
                'type' => 'deposit',
                'status' => 'success',
                'description' => 'Deposit',
            ]);

            TransactionReceipt::create([
                'transaction_id' => $transaction->id,
                'receipt_number' => 'RCP-' . now()->format('Ymd') . '-' . str_pad($transaction->id, 4, '0', STR_PAD_LEFT),
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Deposit successful!');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = User::findOrFail($request->session()->get('id'));

        if ($user->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        DB::transaction(function () use ($user, $request) {
            $user->balance -= $request->amount;
            $user->save();

            $transaction = Transaction::create([
                'sender_account_number' => $user->account_number,
                'receiver_account_number' => null,
                'amount' => $request->amount,
                'type' => 'withdraw',
                'status' => 'success',
                'description' => 'Withdrawal',
            ]);

            TransactionReceipt::create([
                'transaction_id' => $transaction->id,
                'receipt_number' => 'RCP-' . now()->format('Ymd') . '-' . str_pad($transaction->id, 4, '0', STR_PAD_LEFT),
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Withdrawal successful!');
    }

    public function receipt(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $receipt = TransactionReceipt::where('transaction_id', $id)->firstOrFail();
        return view('transactions.receipt', compact('transaction', 'receipt'));
    }
}