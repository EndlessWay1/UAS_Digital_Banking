<!DOCTYPE hyml>
<html>

<body>

<h1>Create Saving Goal</h1>

<form method="POST" action="{{ route('pocket.store') }}">
    @csrf

    Purpose:
    <input type="text" name="purpose">

    <br><br>

    Target Amount:
    <input type="number" name="target_amount">

    <br><br>

    <button type="submit">
        Save
    </button>
</form>
</body>
</html>