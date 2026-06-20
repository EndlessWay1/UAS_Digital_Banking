<!DOCTYPE html>
<html>
<body>
    <h1>Add Money to the Saving Pocket</h1>

    <hr>

    <h3>{{ $pocket->purpose }}</h3>

    <p>Target Amount: {{ $pocket->target_amount }}</p>

    <p>Current Amount: {{ $pocket->current_amount }}</p>

    <form method="POST" action="{{ route('pocket.deposit', $pocket) }}">
        @csrf

        Amount to Add:

        <input type="number" name="amount">

        <br><br>

        <button type="submit">
            Add Money
        </button>
    </form>
</body>
</html>