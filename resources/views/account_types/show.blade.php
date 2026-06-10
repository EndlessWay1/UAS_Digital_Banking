<!DOCTYPE html>
<html>
<head>
    <title>Account Type Detail</title>
</head>
<body>
    <h1>Account Type Detail</h1>

    <p>
        <a href="{{ route('home') }}">Back to Home</a>
        <a href="{{ route('account-types.index') }}">Back to Account Types</a>
    </p>

    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <td>{{ $accountType->name }}</td>
        </tr>
        <tr>
            <th>Code</th>
            <td>{{ $accountType->code }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $accountType->description }}</td>
        </tr>
        <tr>
            <th>Minimum Balance</th>
            <td>Rp {{ number_format($accountType->minimum_balance, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>