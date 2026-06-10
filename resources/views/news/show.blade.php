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
        <span style="font-size: small; color:black">{{ $news->created_at->format('d-m-Y') }}</span><br>
        <br>
        <p>{{ $news->content }}</p>

        <form action="{{ route('create.comment') }}" method="post">
            @csrf
            <input type="hidden" name="news" value="{{ $news->id }}">
            <label for="content">Tulis komentar anda:</label>
            <br>
            <textarea name="comment" required></textarea>
            <br>
            <button type="submit">Kirim</button>
        </form>

        @forelse ($news->comments as $c)
            <h4>{{ $c->user->name }}</h4>
            <p>{{ $c->comment }}</p>
        @empty
            <p>No comments yet.</p>
        @endforelse
    @endif
</body>

</html>
