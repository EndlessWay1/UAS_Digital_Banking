<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardless Deposit</title>
</head>
<body>

    <h1>Cardless Deposit</h1>

    <p>Welcome, {{ $user->name }}</p>
    <p>Current Balance: <strong>Rp {{ number_format($balance, 0, ',', '.') }}</strong></p>

    <form action="{{ route('cardless.deposit') }}" method="POST">
        @csrf
        <label for="amount">Amount (Rp):</label>
        <input type="number" id="amount" name="amount" min="1" required value="{{ old('amount') }}">
        <button type="submit">Deposit</button>
    </form>

    <br>
    <a href="{{ route('cardless.withdraw.form') }}">Go to Withdraw</a> |
    <a href="{{ route('cardless.history') }}">Transaction History</a> |
    <a href="{{ route('home') }}">Back to Home</a>

</body>
</html>