<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function userIndex(Request $request)
    {
        $this->authorize('viewAny', auth()->user());
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // check if the author_id is the same as the session id

        $user = User::findOne($request->user_id);

        return view('admin.edit.users', compact('user'));
    }
}
