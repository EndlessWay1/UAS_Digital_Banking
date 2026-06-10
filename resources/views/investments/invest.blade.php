<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invest</title>
</head>
<body>

    <h1>Make an Investment</h1>

    <p>Welcome, {{ $user->name }}</p>
    <p>Current Account: <strong>{{ $account->account_number }}</strong></p>
    <p>Current Balance: <strong>Rp {{ number_format($account->balance, 0, ',', '.') }}</strong></p>
    
    <form action="{{ route('investments.invest') }}" method="POST">
        @csrf
        <label for="amount">Amount (Rp):</label>
        <input type="number" id="amount" name="amount" min="1" max="{{ $account->balance }}" required value="{{ old('amount') }}">
        <button type="submit">Invest</button>

        <label for="pin">PIN:</label>
        <input type="password" id="pin" name="pin"
            maxlength="6" inputmode="numeric" required>
        @error('pin')
            <p style="color: red;">{{ $message }}</p>
        @enderror
    </form>

    <br>
    <a href="{{ route('investments.liquidate.form') }}">Liquidate</a> |
    <a href="{{ route('investments.history') }}">Investment History</a> |
    <a href="{{ route('home') }}">Back to Home</a>

</body>
</html>