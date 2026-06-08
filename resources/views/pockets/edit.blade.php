<!DOCTYPE html>
<html>

<body>

<h1>Edit Saving Goal</h1>

<form method="POST" acion="{{ route('pocket.update', $pocket) }}">
    @csrf
    @method('PUT')

    Purpose:
    <input type="text" name="purpose" value="{{ $pocket->purpose }}">

    <br><br>

    Target:
    <input type="number" name="target_amount" value="{{ $pocket->target_amount }}">

    <br><br>

    <button type="submit">
        Submit
    </button>

</form>

</body>
</html>
