<!DOCTYPE html>
<html>
<head>
    <title>My Accounts</title>
</head>
<body>
    <h1>My Accounts</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('home') }}">Home</a> |
        <a href="{{ route('accounts.create') }}">Create Account</a> |
        <a href="{{ route('account-types.index') }}">Account Types</a>
    </p>

    @if ($accounts->count() > 0)
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Account Number</th>
                    <th>Type</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->account_number }}</td>
                        <td>{{ $account->accountType->name }}</td>
                        <td>Rp {{ number_format($account->balance, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($account->status) }}</td>
                        <td>{{ $account->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('accounts.show', $account) }}">Detail</a> |
                            <a href="{{ route('accounts.balance', $account) }}">Balance</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No accounts found.</p>
    @endif
</body>
</html>