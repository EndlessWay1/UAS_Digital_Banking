<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'comment' => 'required|string|max:255',
            'news' => 'required|exists:news,id',
        ]);

        auth()->user()->comments()->create([
            'comment' => $validate['comment'],
            'news_id' => $validate['news'],
        ]);

        return redirect()->route('news.show', $validate['news'])
            ->with('success', 'Successfully added comment');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // 
    }
}
