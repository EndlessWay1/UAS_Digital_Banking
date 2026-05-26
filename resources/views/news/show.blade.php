<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>

<body>
    <h1>News Post</h1>

    <a href="{{ route('news.create') }}">Create New Post</a>

    <br>
    <br>

    @if ($posts->isEmpty())
    <p>No News</p>
    @else
    @foreach($posts as $post)
    <h2>{{ $post->title }}</h2>
    <span style="font-size: small; color:gray">{{ $post->author->name }}</span>
    <span style="font-size: small; color:black">{{ $post->timestamp->format('d - m - Y') }}</span>
    <br>
    <p>{{ $post->content }}</p>
    @endforeach
    @endif

</body>

</html>