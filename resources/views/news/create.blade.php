<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create News</title>
</head>

<body>
    <h1>Create News</h1>
    <form method="post" action="{{ route('news.store') }}">
        @csrf

        <span style="font-size: medium;">Name: </span>
        <input type="text" placeholder="Title" id="title" name='title' required autofocus><br>

        <span style="font-size: medium;">Content: </span><br>
        <textarea placeholder="Content" id="content" name='content' rows='8' required></textarea><br>

        <button type="submit">Simpan</button>

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