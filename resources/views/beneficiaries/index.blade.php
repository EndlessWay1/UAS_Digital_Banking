<!DOCTYPE html>
<html lang="en">

<a href="{{ route('home') }}">
    Home
</a>

<head>
    <meta charset="UTF-8">
    <title>Beneficiary List</title>
</head>

<hr>

<body>
    <h1>Beneficiary List</h1>

    <a href="{{ route('beneficiaries.create') }}">
        Add Beneficiary
    </a>

    <br><br>

    @foreach ($beneficiaries as $beneficiary)
        <hr>
        <p>Name:{{ $beneficiary->recipient_name}}</p>
        <p>Bank:{{ $beneficiary->bank_name}}</p>
        <p>Alias:{{ $beneficiary->alias}}</p>
        <a href="{{ route('beneficiaries.edit', $beneficiary) }}">
            Edit
        </a>

        <br><br>
        
        <form method="POST" action="{{ route('beneficiaries.destroy', $beneficiary) }}">
            @csrf
            @method('DELETE')

            <button type="submit">
                Delete
            </button>
        </form>
    @endforeach
</body>
</html>

    