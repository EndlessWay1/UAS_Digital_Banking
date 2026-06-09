<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<h1>User Profile</h1>
@if (!$user){
<h2>
    An Error has Occurred
</h2>
}
@endif

<span style="font-size: medium;">Name: {{ $user->name }}</span><br>
<span style="font-size: medium;">Email: {{ $user->email }}</span><br>
<span style="font-size: medium;">Role: {{ $user->role ?? 'user'}}</span>

<form action="{{ route('profile.edit') }}" method="get">
    @csrf
    <button type="submit">Edit Profile</button>
</form>
<br>
<form action="{{route('home')}}" method="get">
    @csrf
    <button type="submit">Home</button>
</form>

<body>

</body>

</html>