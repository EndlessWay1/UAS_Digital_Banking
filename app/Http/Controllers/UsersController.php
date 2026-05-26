<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.signup');
    }

    /**
     * Log in the user.
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     * Log in the user.
     */
    public function storelogin(Request $request)
    {


        $validated = $request->validate([
            'password' => [
                'required'
            ],
            'email' => ['required'],
        ]);

        // session
        $user = User::where('email', $validated['email'])->first();

        // auth, needs password first
        $checkHash = Hash::check($validated['password'], $user?->password);
        if (!$checkHash || !$user) {
            abort(403, 'Incorrect Password or Email');
        }

        $request->session()->regenerate();
        $request->session()->put('id', $user->id);
        $request->session()->put('role', $user->role);

        return redirect()->route('home')->with('success', 'Successfully Logged In');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/user/login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::email()
                    ->rfcCompliant(strict: false)
                    ->validateMxRecord(),
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);


        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'user'
            ]
        );

        // prevent session fixation
        $request->session()->regenerate();

        $request->session()->put('id', $user->id);
        $request->session()->put('role', $user->role);


        return redirect()->route('home')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // session
        $user = User::query()->findOrFail($request->session()->get('id'));

        return view('users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // check if the author_id is the same as the session id

        $user_id = $request->session()->get('id');
        $user = User::query()->findOrFail($user_id);


        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user_id = $request->session()->get('id');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::email()
                    ->rfcCompliant(strict: false)
                    ->validateMxRecord(),
                Rule::unique('users', 'email')->ignore($user_id),
            ],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'current_password' => [
                'required'
            ]
        ]);

        // session
        $user = User::query()->findOrFail($user_id);

        // auth, needs password first
        $checkHash = Hash::check($request->current_password, $user->password);
        if (!$checkHash) {
            abort(403, 'Incorrect Password');
        }


        $user->update(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password']
            ]
        );


        return redirect()->route('home')->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user_id = $request->session()->get('id');

        $validated = $request->validate([
            'current_password' => [
                'required'
            ]
        ]);

        // session
        $user = User::query()->findOrFail($user_id);

        // auth, needs password first
        $checkHash = Hash::check($request->current_password, $user->password);
        if (!$checkHash) {
            abort(403, 'Incorrect Password');
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'User Deleted Successfully');
    }
}
