<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt</title>
</head>
<body>
    <h1>Transaction Receipt</h1>

    <p><strong>Receipt Number:</strong> {{ $receipt->receipt_number }}</p>
    <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y, H:i') }}</p>
    <p><strong>Type:</strong> {{ ucfirst($transaction->type) }}</p>
    <p><strong>Amount:</strong> Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
    <p><strong>Sender:</strong> {{ $transaction->sender_account_number }}</p>
    <p><strong>Receiver:</strong> {{ $transaction->receiver_account_number ?? '-' }}</p>
    <p><strong>Description:</strong> {{ $transaction->description ?? '-' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>

    <br>
    <a href="{{ route('transactions.index') }}">Back to Transaction History</a>
</body>
</html>