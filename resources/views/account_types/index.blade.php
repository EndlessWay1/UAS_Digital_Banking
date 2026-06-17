<x-layout>
    <x-slot:title>Account Types</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)] px-4">
        <div class="card w-full max-w-6xl bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Account Types</h1>

                        <p class="mt-1 text-sm text-base-content/60">
                            Compare the available account types and their minimum balances.
                        </p>
                    </div>

                    <a href="{{ route('accounts.create') }}" class="btn">
                        Create Account
                    </a>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                        Home
                    </a>

                    <a href="{{ route('accounts.index') }}" class="btn btn-ghost btn-sm">
                        My Accounts
                    </a>
                </div>

                <hr class="h-px my-2 bg-black border-0">

                @if ($accountTypes->count() > 0)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($accountTypes as $type)
                            <div class="rounded-lg bg-[#efefef] px-5 py-5 shadow-lg">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h2 class="text-xl font-bold">
                                            {{ $type->name }}
                                        </h2>

                                        <span class="badge badge-ghost mt-2">
                                            {{ strtoupper($type->code) }}
                                        </span>
                                    </div>
                                </div>

                                <p class="mt-4 text-sm text-base-content/70">
                                    {{ $type->description ?: 'No description available.' }}
                                </p>

                                <div class="mt-5 rounded-lg bg-base-100 p-4 shadow">
                                    <p class="text-xs text-base-content/60">
                                        Minimum Balance
                                    </p>

                                    <p class="mt-1 text-lg font-bold">
                                        Rp {{ number_format($type->minimum_balance, 0, ',', '.') }}
                                    </p>
                                </div>

                                <a
                                    href="{{ route('account-types.show', $type) }}"
                                    class="btn btn-ghost mt-4 w-full"
                                >
                                    View Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-lg bg-[#efefef] px-6 py-10 text-center shadow-lg">
                        <h2 class="text-xl font-bold">
                            No account types found
                        </h2>

                        <p class="mt-2 text-sm text-base-content/60">
                            Account type data has not been added.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>