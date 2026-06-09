<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>

<body>
    <h1>Edit Profile</h1>
    <br>
    <form method="post" action="{{ route('profile.delete', request()) }}">
        @csrf
        @method('DELETE')

        <span style="font-size: medium;">Password: </span>
        <input type="password" placeholder="New Password" name="current_password" required><br>

        <button type="submit">Remove</button>

    </form>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</body>

</html>