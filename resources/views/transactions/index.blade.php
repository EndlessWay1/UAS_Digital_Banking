<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
</head>
<body>
    <h1>Transaction History</h1>
    <p>Welcome, {{ $user->name }}</p>

    <a href="{{ route('transactions.transfer.form') }}">Transfer</a> |
    <a href="{{ route('transactions.deposit.form') }}">Deposit</a> |
    <a href="{{ route('transactions.withdraw.form') }}">Withdraw</a> |
    <a href="{{ route('home') }}">Back to Home</a>

    <br><br>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Description</th>
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
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>
                        <a href="{{ route('transactions.receipt', $transaction->id) }}">View Receipt</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No transactions yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>