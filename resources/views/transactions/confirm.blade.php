<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Transaction</title>
</head>
<body>
    <h1>Confirm {{ ucfirst($type) }}</h1>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif

    <table border="1" cellpadding="10">
        <tr>
            <td>Transaction Type</td>
            <td>{{ ucfirst($type) }}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>Rp {{ number_format($amount, 0, ',', '.') }}</td>
        </tr>
        @if($type === 'transfer')
        <tr>
            <td>To Account</td>
            <td>{{ $receiver_account_number }}</td>
        </tr>
        @endif
        @if(!empty($description))
        <tr>
            <td>Description</td>
            <td>{{ $description }}</td>
        </tr>
        @endif
        @if(!empty($tags))
        <tr>
            <td>Tags</td>
            <td>{{ implode(', ', $tags) }}</td>
        </tr>
        @endif
    </table>

    <br>
    <form action="{{ route('transactions.' . $type) }}" method="POST">
        @csrf
        <input type="hidden" name="amount" value="{{ $amount }}">
        @if($type === 'transfer')
            <input type="hidden" name="receiver_account_number" value="{{ $receiver_account_number }}">
            <input type="hidden" name="description" value="{{ $description }}">
        @endif
        @if(!empty($tags))
            @foreach($tags as $tag)
                <input type="hidden" name="tags[]" value="{{ $tag }}">
            @endforeach
        @endif

        <label for="pin">Enter PIN to confirm:</label>
        <input type="password" id="pin" name="pin" required maxlength="6">
        <br><br>

        <button type="submit">Confirm {{ ucfirst($type) }}</button>
        <a href="{{ url()->previous() }}">Cancel</a>
    </form>
</body>
</html>