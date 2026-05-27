<?php

namespace App\Http\Controllers;

use App\Models\News;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = News::with('author')->get(['*']);
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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        News::create(
            [
                'title' => $request->title,
                'content' => $request->content,
                'author_id' => $request->session()->get('id'),
            ]
        );

        return redirect()->route('news.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, News $news)
    {
        // check if the author_id is the same as the session id

        $user_id = $request->session()->get('id');
        if ($user_id != $news->author_id) {
            abort(403, 'Unauthorized Access');
        }

        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {

        // check if the author_id is the same as the session id

        $user_id = $request->session()->get('id');
        if ($user_id != $news->author_id) {
            abort(403, 'Unauthorized Access');
        }

        $news->update($request->only('title', 'content'));

        return redirect()->route('news.show', $news)->with('Success', 'News Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, News $news)
    {
        // check if the author_id is the same as the session id

        $user_id = $request->session()->get('id');
        if ($user_id != $news->author_id) {
            abort(403, 'Unauthorized Access');
        }

        $news->delete();

        return redirect()->route('news.index')->with('Success', 'News Deleted Successfully');
    }
}
