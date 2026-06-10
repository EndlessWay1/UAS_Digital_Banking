<x-layout>
    <x-slot:title>
        Sign Up
    </x-slot:title>


    <div class='hero min-h-[calc(100vh-16rem)]'>
        <div class="hero-content flex-col gap-3">
            <div class="card w-96 bg-base-100">
                <div class="card-body">

                    <h1 class="text-3xl font-bold text-center">Sign In Account</h1>
                    <div class=' rounded-lg mt-2'>
                        <form method="post" action="{{ route('storelogin') }}" class="flex flex-col gap-4">
                            @csrf

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
                                <input class='input' type="password" placeholder="password" name="password"
                                    id="password" required><br>
                                @error('password')
                                    <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                @enderror

                            </div>

                            <div class="form-control mt-8">
                                <button class='btn btn-primary btn-sm w-full' type="submit">Sign In</button>
                            </div>
                            <p class="text-center text-sm">
                                Don't have an account?
                                <a href="{{ route('signup') }}" class="link link-primary">Sign Up</a>

                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
