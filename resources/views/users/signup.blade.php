<x-layout>
    <x-slot:title>
        Sign Up
    </x-slot:title>


    <div class='hero min-h-[calc(100vh-16rem)]'>
        <div class="hero-content flex-col gap-3">
            <div class="card w-96 bg-base-100">
                <div class="card-body">

                    <h1 class="text-3xl font-bold text-center">Create Account</h1>
                    <div class=' rounded-lg mt-2'>
                        <form method="post" action="{{ route('storeUser') }}" class="flex flex-col gap-4">
                            @csrf
                            <div>
                                <span>Name:</span>
                                <input class='input @error('name') input-error @enderror' type="text"
                                    placeholder="Name" id="name" name='name' required autofocus>

                                @error('name')
                                    <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <span>Email: </span>
                                <input class="input" type="email" placeholder="email" id="email" name='email'
                                    required>

                                @error('email')
                                    <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <span>Password: </span>
                                <input class="input @error('name') input-error @enderror" type="password"
                                    placeholder="password" name="password" required>

                                @error('password')
                                    <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <span>Confirm Password: </span>
                                <input class="input" type="password" placeholder="password"
                                    name="password_confirmation" required>
                            </div>
                            @auth
                                @can('viewAny', auth()->user())
                                    <div>

                                        <span>Role: </span>
                                        <select id="role" class="input" name="role">
                                            <option selected>Choose a role</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                            <option value="clerk">Clerk</option>
                                        </select>
                                        @error('role')
                                            <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endcan
                            @endauth
                    </div>





                    <div class="form-control mt-8">
                        <button class='btn btn-primary btn-sm w-full' type="submit">Sign Up</button>
                    </div>
                    <p class="text-center text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="link link-primary">Sign In</a>

                    </p>


                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout>
