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
    <form method="post" action="{{ route('profile.update', request()) }}">
        @csrf
        @method('PUT')

        <span style="font-size: medium;">Name: </span>
        <input type="text" placeholder="{{ $user->name }}" id="name" name='name' required autofocus><br>

        <span style="font-size: medium;">Email: </span>
        <input type="email" placeholder="{{ $user->email }}" id="email" name='email' required><br>

        <span style="font-size: medium;">Current Password: </span>
        <input type="password" placeholder="New Password" name="current_password" required><br>
        <span style="font-size: medium;">New Password: </span>
        <input type="password" placeholder="New Password" name="password" required><br>

        <button type="submit">Update</button>

    </form>

    <form action="{{ route('profile.remove') }}" method="get">
        <button type="submit">Delete User</button>
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