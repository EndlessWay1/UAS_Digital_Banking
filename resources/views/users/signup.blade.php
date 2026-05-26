<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>
    <h1>Sign Up</h1>
    <span style="font-size: medium; color:gray"><a href=" {{ route('login') }}">Login</a></span>
    <br>
    <br>
    <form method="post" action="{{ route('storeUser') }}">
        @csrf

        <span style="font-size: medium;">Name: </span>
        <input type="text" placeholder="name" id="name" name='name' required autofocus><br>

        <span style="font-size: medium;">Email: </span>
        <input type="email" placeholder="email" id="email" name='email' required><br>

        <span style="font-size: medium;">Password: </span>
        <input type="password" placeholder="password" name="password" required><br>

        <button type="submit">Sign Up</button>

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