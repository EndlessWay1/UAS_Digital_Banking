<!DOCTYPE html>
<html>
<body>

<a href="{{ route('home') }}">
    Home
</a>

<h1>My Savings Pocket</h1>

<a href="{{ route('pocket.create') }}">
    Create New Pocket
</a>

<hr>

@foreach($pockets as $pocket)

<h3>{{ $pocket->purpose }}</h3>

<p>Target: {{ $pocket->target_amount }}</p>

<p>Current Balance: {{ $pocket->current_amount }} </p>

@if($pocket->target_amount > 0)
    <p>
        Progress:
        {{ round(($pocket->current_amount / $pocket->target_amount) * 100, 2) }}%
    </p>
@else
    <p>Progress: 0%</p>
@endif

@if($pocket->current_amount >= $pocket->target_amount)
    <p>Status: Completed </p>
@else
    <p>Status: In Progress </p>
@endif

<a href="{{ route('pocket.deposit.form', $pocket) }}">
    Add Money
</a>

<br><br>

<a href="{{ route('pocket.edit', $pocket) }}">
    Edit
</a>

<br><br>

<form method="POST" action="{{ route('pocket.destroy', $pocket) }}">
    @csrf
    @method('DELETE')

    <button type="Submit">
        Delete
    </button>
</form>

<hr>

@endforeach

</body>
</html>