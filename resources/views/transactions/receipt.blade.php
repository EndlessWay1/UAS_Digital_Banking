<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt</title>
</head>
<body>
    <h1>Transaction Receipt</h1>

    <table border="1" cellpadding="10">
        <tr>
            <td>Receipt Number</td>
            <td>{{ $receipt->receipt_number }}</td>
        </tr>
        <tr>
            <td>Transaction Type</td>
            <td>{{ ucfirst($transaction->type) }}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>From</td>
            <td>{{ $transaction->sender_account_number }}</td>
        </tr>
        <tr>
            <td>To</td>
            <td>{{ $transaction->receiver_account_number ?? '-' }}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{ $transaction->description ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tags</td>
            <td>
                @if(!empty($transaction->tags))
                    {{ implode(', ', $transaction->tags) }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ ucfirst($transaction->status) }}</td>
        </tr>
        <tr>
            <td>Date & Time</td>
            <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
        </tr>
    </table>

    <br>
    <a href="{{ route('transactions.index') }}">Back to Transaction History</a>
</body>
</html>