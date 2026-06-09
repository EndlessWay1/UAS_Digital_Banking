<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardless Withdrawal</title>
</head>
<body>

    <h1>Cardless Withdrawal</h1>

    <p>Welcome, {{ $user->name }}</p>
    <p>Current Balance: <strong>Rp {{ number_format($balance, 0, ',', '.') }}</strong></p>

    <form action="{{ route('cardless.withdraw') }}" method="POST">
        @csrf
        <label for="amount">Amount (Rp):</label>
        <input type="number" id="amount" name="amount" min="1" max="{{ $balance }}" required value="{{ old('amount') }}">
        <button type="submit">Withdraw</button>
    </form>

    <br>
    <a href="{{ route('cardless.deposit.form') }}">Go to Deposit</a> |
    <a href="{{ route('cardless.history') }}">Transaction History</a> |
    <a href="{{ route('home') }}">Back to Home</a>

</body>
</html>