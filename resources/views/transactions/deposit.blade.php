<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit</title>
</head>
<body>
    <h1>Deposit</h1>
    <p>Account: {{ $account->account_number }}</p>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif
    <form action="{{ route('transactions.deposit') }}" method="POST">
        @csrf
        <label for="amount">Amount (Rp):</label>
        <input type="number" id="amount" name="amount" min="1" required value="{{ old('amount') }}">
        <br><br>
        <button type="submit">Deposit</button>
    </form>
    <br>
    <a href="{{ route('transactions.index') }}">Back to Transaction History</a>
</body>
</html>