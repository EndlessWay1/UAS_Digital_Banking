<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
</head>
<body>
    <h1>Transaction History</h1>
    <p>Account: {{ $account->account_number }}</p>
    <a href="{{ route('transactions.transfer.form') }}">Transfer</a> |
    <a href="{{ route('transactions.deposit.form') }}">Deposit</a> |
    <a href="{{ route('transactions.withdraw.form') }}">Withdraw</a> |
    <a href="{{ route('home') }}">Back to Home</a>
    <br><br>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="GET" action="{{ route('transactions.index') }}">
        <input type="text" name="search" placeholder="Search by description..." value="{{ request('search') }}">
        <select name="type">
            <option value="">All Types</option>
            <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Transfer</option>
            <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Deposit</option>
            <option value="withdraw" {{ request('type') === 'withdraw' ? 'selected' : '' }}>Withdraw</option>
        </select>
        <button type="submit">Filter</button>
        <a href="{{ route('transactions.index') }}">Reset</a>
    </form>
    <br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Description</th>
                <th>Tags</th>
                <th>Status</th>
                <th>Receipt</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ $transaction->sender_account_number }}</td>
                    <td>{{ $transaction->receiver_account_number ?? '-' }}</td>
                    <td>{{ $transaction->description ?? '-' }}</td>
                    <td>
                        @if(!empty($transaction->tags))
                            {{ implode(', ', $transaction->tags) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>
                        <a href="{{ route('transactions.receipt', $transaction->id) }}">View Receipt</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No transactions yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>