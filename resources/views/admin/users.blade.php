<x-layout>
    <x-slot:title>
        Users
    </x-slot:title>

    <div class="min-h-[calc(100vh-16rem)] bg-base-100 rounded-lg justify-center">

        <h1 class="text-3xl font-bold text-center pt-4 pb-3">All Users</h1>
        <div class="card-body flex flex-row gap-4 min-w-sm ">
            @foreach ($users as $user)
                <div class="flex flex-col gap-3 bg-[#efefef] px-3 py-2 rounded-lg shadow-lg">

                    <div class="flex justify-between w-full">
                        <a href="{{ route('profile', $user) }}" class="text-xl font-bold mt-1">{{ $user->name }}</a>
                        <span class="text-xs ext-base-content/60 mt-1">
                            {{ $user->created_at->format('d-m-Y') }}</span>

                    </div>
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm font-bold">Email: </span>
                        <span class="rounded-lg bg-base-200 px-2 text-sm border">{{ $user->email }}</span>
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm font-bold">Role: </span>
                        <span class="rounded-lg bg-base-200 px-2 text-sm border">{{ $user->role ?? 'user' }}</span>
                    </div>
                    <div class="flex flex-row gap-4 justify-center mt-1">
                        <a href="{{ route('profile.edit', $user, request()) }}" class='btn min-w-5vh'>Edit User</a>
                        <a href="{{ route('profile.remove', $user, request()) }}" class='btn min-w-5vh'>Delete User</a>
                        <a href="{{ route('news.user.show', $user) }}" class="btn w-5vh">News Made</a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</x-layout>
