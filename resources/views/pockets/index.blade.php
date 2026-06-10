<!DOCTYPE html>
<html>
<body>

<h1>My Savings Pocket</h1>

<a href="{{ route('pocket.create') }}">
    Create New Pocket
</a>

<hr>

@foreach($pockets a $pocket)

<h3>{{ $pocket->purpose }}</h3>

<p>Target: {{ $pocket->target_amount }}</p>

<p>Current Balance: {{ $pocket->current_amount }} </p>

<p>Progress: {{ round(($pocket->current_amount / $pocket->target_amount) * 100, 2) }}%</p>

<p>Status: {{ $pocket->status }}</p>

<a href="{{ route('pocket.edit', $pocket) }}">
</a>

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