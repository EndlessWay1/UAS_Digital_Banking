<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = News::with('author')->latest()->take(10)->get(['*']);
        return view('news.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $valid = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:65535'
        ], [
            'content.required' => 'Please write something in the content',
            'title.required' => 'Please write something in the title',
        ]);
        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('news.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->load('comments.user');
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        // check if the author_id is the same as the session id

        $this->authorize('update', $news);

        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {

        // check if the author_id is the same as the session id

        $this->authorize('update', $news);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:65535'
        ], [
            'content.required' => 'Please write something in the content',
            'title.required' => 'Please write something in the title',
        ]);


        $news->update($validated);

        return redirect()->route('news.show', $news)->with('Success', 'News Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // check if the author_id is the same as the session id
        $this->authorize('delete', $news);

        $news->delete();

        return redirect()->route('news.index')->with('Success', 'News Deleted Successfully');
    }
}
