<!DOCTYPE html>
<html>
<head>
    <title>Account Detail</title>
</head>
<body>
    <h1>Account Detail</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('accounts.index') }}">Back to Accounts</a> |
        <a href="{{ route('accounts.balance', $account) }}">View Balance</a>
    </p>

    <table border="1" cellpadding="8">
        <tr>
            <th>Owner</th>
            <td>{{ $account->user->name }}</td>
        </tr>
        <tr>
            <th>Account Number</th>
            <td>{{ $account->account_number }}</td>
        </tr>
        <tr>
            <th>Account Type</th>
            <td>{{ $account->accountType->name }}</td>
        </tr>
        <tr>
            <th>Balance</th>
            <td>Rp {{ number_format($account->balance, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($account->status) }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $account->created_at->format('d M Y H:i') }}</td>
        </tr>
    </table>
</body>
</html>