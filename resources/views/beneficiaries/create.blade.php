<!DOCTYPE html>
<html lang="en">

<a href="{{ route('home') }}">
    Home
</a>

<head>
    <meta charset="UTF-8">
    <title>Add Beneficiary</title>
</head>

<body>
    <h1>Add Beneficiary</h1>
    <form action="{{ route('beneficiaries.store') }}" method="POST">
        @csrf

        <span>Account Number:</span>
        <input type="text" name="account_number" required>
        <br><br>

        <span>Alias:</span>
        <input type="text" name="alias">
        <br><br>

        <button type="submit">
            Save Beneficiary
        </button>
    </form>

    @if ($errors->any())
        <ul>
            @foreach (errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</body>

</html>
