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
    <span style="font-size: small; color:gray">{{ $post->author->name }}</span><br>
    <span style="font-size: small; color:black">{{ $post->created_at->format('d-m-Y')}}</span><br>
    <a href="{{ route('news.show', $post )}}">News Link</a>
    <br>
    <p style="width:20rem;
    height:2rem;
    padding:1rem 1rem;
    overflow:hidden; 
    border:1px solid #f00;
    text-overflow:ellipsis;
    white-space:nowrap; ">{{ $post->content }}</p>
    @endforeach
    @endif

</body>

</html>