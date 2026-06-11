<x-layout>

    <x-slot:title>Profile</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)]">
        <div class="card w-9/12 bg-base-100 ">
            <div class="card-body">
                <h1 class="text-3xl font-bold text-left">User Profile</h1>
                <hr class="h-px my-2 bg-black border-0">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <span class="text-lg font-bold">Name: </span>
                        <span class="rounded-lg bg-base-200 px-2 py-1 text-lg border">{{ $user->name }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-lg font-bold">Email: </span>
                        <span class="rounded-lg bg-base-200 px-2 py-1 text-lg border">{{ $user->email }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-lg font-bold">Role: </span>
                        <span class="rounded-lg bg-base-200 px-2 py-1 text-lg border">{{ $user->role ?? 'user' }}</span>
                    </div>
                </div>
                <div class="flex flex-row gap-4 justify-center mt-8">
                    <a href="{{ route('profile.edit') }}" class='btn w-10vh'>Edit Profile</a>

                    <a href="{{ route('home') }} " class="btn w-10vh">Home</a>
                </div>

            </div>
        </div>
    </div>

</x-layout>
