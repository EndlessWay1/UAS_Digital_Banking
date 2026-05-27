<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Beneficiary List</title>
</head>

<body>
    <h1>Beneficiary List</h1>

    <a href="{{ route('beneficiaries.create') }}">
        Add Beneficiary
    </a>

    <br><br>

    @foreach ($beneficiaries as $beneficiary)
        <hr>
        <p>Name:{{ $beneficiaries->recipient_name}}</p>
        <p>Bank:{{ $beneficiaries->bank_name}}</p>
        <p>Alias:{{ $beneficiaries->alias}}</p>
    @endforeach
</body>
</html>

    