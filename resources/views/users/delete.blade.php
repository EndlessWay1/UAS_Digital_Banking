<x-layout>
    <x-slot:title>
        Delete User
    </x-slot:title>


    <br>
    <div class="flex justify-center min-h-[calc(100vh-16rem)]">
        <div class="card w-9/12 bg-base-100 ">
            <div class="card-body">
                <h1 class="text-3xl font-bold text-center">Delete User</h1>
                <hr class="h-px my-2 bg-black border-0">

                <form action="{{ route('profile.delete', $user) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <div class="flex flex-col gap-3">
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
                        @else
                            <h1 class="text-xl text-center mt-4">
                                Delete {{ $user->name }}?
                            </h1>
                        @endif
                    </div>
                    <div class="form-control mt-8">
                        <button class='btn btn-primary btn-sm w-full' type="submit">Delete User</button>
                    </div>

                </form>

                <div class="flex flex-row gap-4 justify-center mt-8">
                    <a href="{{ route('home') }}" class='btn w-10vh'>Go Back</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layout>
