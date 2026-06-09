<!DOCTYPE html>
<html>
<head>
    <title>Account Types</title>
</head>
<body>
    <h1>Account Types</h1>

    <p>
        <a href="{{ route('accounts.index') }}">Back to Accounts</a>
    </p>

    @if ($accountTypes->count() > 0)
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Minimum Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accountTypes as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->code }}</td>
                        <td>{{ $type->description }}</td>
                        <td>Rp {{ number_format($type->minimum_balance, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('account-types.show', $type) }}">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No account types found.</p>
    @endif
</body>
</html>