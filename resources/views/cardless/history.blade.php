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
    <p>Current Balance: <strong>Rp {{ number_format($balance, 0, ',', '.') }}</strong></p>

    @if ($transactions->isEmpty())
        <p>No transactions yet.</p>
    @else
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount (Rp)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <br>
    <a href="{{ route('cardless.deposit.form') }}">Deposit</a> |
    <a href="{{ route('cardless.withdraw.form') }}">Withdraw</a> |
    <a href="{{ route('home') }}">Back to Home</a>

</body>
</html>