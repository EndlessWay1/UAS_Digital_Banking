<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer</title>
</head>
<body>
    <h1>Transfer</h1>
    <p>Account: {{ $account->account_number }}</p>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif
    <form action="{{ route('transactions.transfer') }}" method="POST">
        @csrf
        <label for="receiver_account_number">Receiver Account Number:</label>
        <input type="text" id="receiver_account_number" name="receiver_account_number" required value="{{ old('receiver_account_number') }}">
        <br><br>
        <label for="amount">Amount (Rp):</label>
        <input type="number" id="amount" name="amount" min="1" required value="{{ old('amount') }}">
        <br><br>
        <label for="description">Description (optional):</label>
        <input type="text" id="description" name="description" value="{{ old('description') }}">
        <br><br>
        <label>Tags (optional):</label><br>
        @foreach(['food', 'transport', 'bills', 'entertainment', 'savings', 'other'] as $tag)
            <input type="checkbox" name="tags[]" value="{{ $tag }}"
                {{ in_array($tag, old('tags', [])) ? 'checked' : '' }}>
            <label>{{ $tag }}</label>
        @endforeach
        <br><br>
        <button type="submit">Transfer</button>
    </form>
    <br>
    <a href="{{ route('transactions.index') }}">Back to Transaction History</a>
</body>
</html>