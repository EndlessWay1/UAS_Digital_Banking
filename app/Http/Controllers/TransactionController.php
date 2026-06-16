<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\TransactionReceipt;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    private function getAccount(Request $request)
    {
        $account = Account::where('user_id', $request->session()->get('id'))->firstOrFail();

        if ($account->status !== 'active') {
            abort(403, 'Your account is not active.');
        }

        return $account;
    }

    public function index(Request $request)
    {
        $account = $this->getAccount($request);
        $transactions = Transaction::where('sender_account_number', $account->account_number)
            ->orWhere('receiver_account_number', $account->account_number)
            ->latest()
            ->get();
        return view('transactions.index', compact('account', 'transactions'));
    }

    public function transferForm(Request $request)
    {
        $account = $this->getAccount($request);
        return view('transactions.transfer', compact('account'));
    }

    public function depositForm(Request $request)
    {
        $account = $this->getAccount($request);
        return view('transactions.deposit', compact('account'));
    }

    public function withdrawForm(Request $request)
    {
        $account = $this->getAccount($request);
        return view('transactions.withdraw', compact('account'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'receiver_account_number' => 'required',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
        ]);
        $sender = $this->getAccount($request);
        $receiver = Account::where('account_number', $request->receiver_account_number)->first();
        if (!$receiver) {
            return back()->withErrors(['receiver_account_number' => 'Account number not found.']);
        }
        if ($sender->account_number === $request->receiver_account_number) {
            return back()->withErrors(['receiver_account_number' => 'You cannot transfer to your own account.']);
        }
        if ($receiver->status !== 'active') {
            return back()->withErrors(['receiver_account_number' => 'Receiver account is not active.']);
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
                'tags' => $request->tags ?? [],
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
            'tags' => 'nullable|array',
        ]);
        $account = $this->getAccount($request);
        DB::transaction(function () use ($account, $request) {
            $account->balance += $request->amount;
            $account->save();
            $transaction = Transaction::create([
                'sender_account_number' => $account->account_number,
                'receiver_account_number' => null,
                'amount' => $request->amount,
                'type' => 'deposit',
                'status' => 'success',
                'description' => 'Deposit',
                'tags' => $request->tags ?? [],
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
            'tags' => 'nullable|array',
        ]);
        $account = $this->getAccount($request);
        if ($account->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }
        DB::transaction(function () use ($account, $request) {
            $account->balance -= $request->amount;
            $account->save();
            $transaction = Transaction::create([
                'sender_account_number' => $account->account_number,
                'receiver_account_number' => null,
                'amount' => $request->amount,
                'type' => 'withdraw',
                'status' => 'success',
                'description' => 'Withdrawal',
                'tags' => $request->tags ?? [],
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