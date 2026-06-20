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
    @if ($account)
        <p>Current Account: <strong>{{ $account->account_number }}</strong></p>
        <p>Current Balance: <strong>Rp {{ number_format($account->balance, 0, ',', '.') }}</strong></p>

        <form action="{{ route('cardless.deposit') }}" method="POST">
            @csrf
            <label for="amount">Amount (Rp):</label>
            <input type="number" id="amount" name="amount" min="1" required value="{{ old('amount') }}">
            <button type="submit">Deposit</button>

            <label for="pin">PIN:</label>
            <input type="password" id="pin" name="pin" maxlength="6" inputmode="numeric" required>
            @error('pin')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </form>

        <br>
        <a href="{{ route('cardless.withdraw.form') }}">Go to Withdraw</a> |
        <a href="{{ route('cardless.history') }}">Cardless Transaction History</a> |
    @else
        <span class="text-sm font-semibold">You don't have a cardless accounts, <a
                href="{{ route('accounts.create') }}">create one.</a></span><br>
    @endif
    <a href="{{ route('home') }}">Back to Home</a>
</body>

</html>
