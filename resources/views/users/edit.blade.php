<x-layout>
    <x-slot:title>
        Edit Profile
    </x-slot:title>


    <br>
    <div class="flex justify-center min-h-[calc(100vh-16rem)]">
        <div class="card w-9/12 bg-base-100 ">
            <div class="card-body">
                <h1 class="text-3xl font-bold text-center">Edit Profile</h1>
                <h1 class="text-3xl font-bold text-left">User Profile</h1>
                <hr class="h-px my-2 bg-black border-0">

                <form action="{{ route('profile.update', $user, request()) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-1">
                            <span class="text-lg font-bold">Name: </span>
                            <input
                                class="rounded-lg bg-base-200 px-2 py-1 text-lg border @error('name') input-error @enderror"
                                type='text' name='name' value="{{ $user->name }}"></input>

                            @error('name')
                                <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-lg font-bold">Email: </span>
                            <input type="email"
                                class="@error('email') input-error @enderror rounded-lg bg-base-200 px-2 py-1 text-lg border"
                                name='email' required value="{{ $user->email }}"></input>
                            @error('email')
                                <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>
                        @if (auth()->user()->role != 'admin')
                            <div class="flex flex-col gap-1">
                                <span class="text-lg font-bold">Password: </span>
                                <input type="password"
                                    class="@error('password') input-error @enderror rounded-lg bg-base-200 px-2 py-1 text-lg border"
                                    name='password' required></input>
                                @error('password')
                                    <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <span class="text-lg font-bold">New Password: </span>
                                <input type="password"
                                    class="@error('new_pass') input-error @enderror rounded-lg bg-base-200 px-2 py-1 text-lg border"
                                    name='new_pass' required></input>
                                @error('new_pass')
                                    <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <span class="text-lg font-bold">Confirm New Password: </span>
                                <input type="password" class="rounded-lg bg-base-200 px-2 py-1 text-lg border"
                                    name='confirm_new_pass' required></input>
                            </div>
                        @else
                            <div class="flex flex-col gap-1">
                                <span class="text-lg font-bold">Role: </span>
                                <select id="role"
                                    class="rounded-lg bg-base-200 px-2 py-1 text-lg border bg-neutral-secondary-medium rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body"
                                    name="role">
                                    <option selected>Choose a role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="clerk">Clerk</option>
                                </select>
                                @error('role')
                                    <p class="text-error text-xs mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                    <div class="form-control mt-8">
                        <button class='btn btn-primary btn-sm w-full' type="submit">Save Profile</button>
                    </div>

                </form>

                <div class="flex flex-row gap-4 justify-center mt-8">
                    <a href="{{ route('home') }}" class='btn w-10vh'>Go Back</a>


                    <a href="{{ route('profile.remove', $user) }} " class="btn w-10vh">Delete User</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layout>
