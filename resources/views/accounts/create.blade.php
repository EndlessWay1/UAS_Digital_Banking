<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
</head>
<body>
    <h1>Create New Account</h1>

    <p>
        <a href="{{ route('accounts.index') }}">Back to Accounts</a>
    </p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('accounts.store') }}">
        @csrf

        <div>
            <label>Account Type</label><br>
            <select name="account_type_id" required>
                <option value="">-- Select Account Type --</option>
                @foreach ($accountTypes as $type)
                    <option value="{{ $type->id }}" {{ old('account_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }} - Min Balance Rp {{ number_format($type->minimum_balance, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label>PIN</label><br>
            <input type="password" name="pin" maxlength="6" required>
            <small>PIN must be 6 digits.</small>
        </div>

        <br>

        <div>
            <label>Confirm PIN</label><br>
            <input type="password" name="pin_confirmation" maxlength="6" required>
        </div>

        <br>

        <button type="submit">Create Account</button>
    </form>
</body>
</html>