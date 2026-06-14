<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class UsersController extends Controller
{

    use AuthorizesRequests;

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
            'email' => 'required|email',
        ]);

        // session
        if (Auth::attempt($validated, $request->boolean('remember'))) {
            $user = Auth::user();
            $request->session()->regenerate();

            $request->session()->put('id', $user->id);
            $request->session()->put('role', $user->role);

            return redirect()->route('home')->with('success', 'Successfully Logged In');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/user/login')->with('success', 'You\'ve been successfully logged out');
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
                    ->uncompromised(),
                'confirmed'
            ],
        ]);



        if (!auth()->check() || auth()->user()->role != 'admin') {
            $user = User::create(
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => 'user'
                ]
            );
            Auth::login($user);

            $request->session()->put('id', $user->id);
            $request->session()->put('role', $user->role);
            return redirect()->route('home')->with('success', 'User created successfully');
        } else {
            $user = User::create(
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => $request->validate(['role' => 'required|in:admin,clerk,user'], ['role.in' => 'Role must be filled!'])['role']
                ]
            );
            return redirect()->route('users')->with('success', 'User created successfully');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        $this->authorize('view', $user);

        return view('users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // check if the author_id is the same as the session id

        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {

        $this->authorize('update', $user);



        if (auth()->user()->role == 'admin') {


            $validated = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => [
                        'required',
                        Rule::email()
                            ->rfcCompliant(strict: false)
                            ->validateMxRecord(),
                        Rule::unique('users', 'email')->ignore($user->id),
                    ],
                    'role' => 'required|in:admin,user,clerk'
                ],
                [
                    'role.in' => 'Role must be selected!'
                ]
            );

            $users = $user->update(
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'role' => $validated['role']
                ]
            );
            return redirect()->route('users')->with('success', 'User Updated Successfully');
        } else {
            // auth, needs password first

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    Rule::email()
                        ->rfcCompliant(strict: false)
                        ->validateMxRecord(),
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                'new_pass' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                    'confirmed:confirm_new_pass'
                ],
                'password' => [
                    'required'
                ]
            ]);
            $checkHash = Hash::check($request->password, $user->password);
            if (!$checkHash) {
                return back()->withErrors('password', 'Incorrect Password!');
            }
            $user->update(
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => $validated['password']
                ]
            );
            return redirect()->route('profile', $user)->with('success', 'User Updated Successfully');
        }
    }


    /**
     * Return form for deletion from storage.
     */
    public function remove(User $user)
    {

        $this->authorize('delete', $user);
        return view('users.delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {

        $this->authorize('delete', $user);

        if (auth()->user()->role != 'admin') {

            $request->validate([
                'current_password' => [
                    'required'
                ]
            ]);


            // auth, needs password first
            $checkHash = Hash::check($request->current_password, $user->password);
            if (!$checkHash) {
                return back()->withErrors('password', 'Incorrect Password!');
            }
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $user->delete();

            return redirect()->route('login')->with('success', 'User Deleted Successfully');
        } else {
            $name = $user->name;
            $user->delete();
            return redirect()->route('users')->with('success', 'User ' . $name . ' Deleted Successfully');
        }
    }
}
