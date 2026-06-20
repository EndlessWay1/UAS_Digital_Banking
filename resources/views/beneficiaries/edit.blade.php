<!DOCTYPE html>
<html>
<body>

<a href="{{ route('home') }}">
    Home
</a>

<head>
    <meta charset="UTF-8">
    <title>Beneficiary List</title>
</head>

<hr>

<h1>Edit Beneficiary</h1>

    <form method="POST" action="{{ route('beneficiaries.update', $beneficiary) }}">
        @csrf
        @method('PUT')

        Recipient Name:
        <input type="text" name="recipient_name" value="{{ $beneficiary->recipient_name }}">

        <br><br>

        Account Number:
        <input type="text" name="account_number" value="{{ $beneficiary->account_number }}">

        <br><br>

        Bank Name:
        <input type="text" name="bank_name" value="{{ $beneficiary->bank_name }}">

        <br><br>

        Alias:
        <input type="text" name="alias" value="{{ $beneficiary->alias }}">

        <br><br>

        <button type="submit">
            Update Beneficiary
        </button>

    </form>

</body>
</html>