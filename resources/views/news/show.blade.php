<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>

<body>
    <h1>News Post</h1>

    <a href="{{ route('news.index') }}">News Home</a>

    @if (!$news)
    <p>News Has Been Deleted</p>
    @else
    <h2>{{ $news->title }}</h2>
    <span style="font-size: small; color:gray">{{ $news->author->name }}</span><br>
    <span style="font-size: small; color:black">{{ $news->created_at->format('d-m-Y')}}</span><br>
    <br>
    <p>{{ $news->content }}</p>
    @endif
</body>

</html>