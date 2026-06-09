<!DOCTYPE html>
<html>
<head>
    <title>Account Balance</title>
</head>
<body>
    <h1>Account Balance</h1>

    <p>
        <a href="{{ route('accounts.index') }}">Back to Accounts</a> |
        <a href="{{ route('accounts.show', $account) }}">Account Detail</a>
    </p>

    <table border="1" cellpadding="8">
        <tr>
            <th>Account Number</th>
            <td>{{ $account->account_number }}</td>
        </tr>
        <tr>
            <th>Account Type</th>
            <td>{{ $account->accountType->name }}</td>
        </tr>
        <tr>
            <th>Current Balance</th>
            <td><strong>Rp {{ number_format($account->balance, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($account->status) }}</td>
        </tr>
    </table>
</body>
</html>