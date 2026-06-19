<x-layout>
    <x-slot:title>Account Type Detail</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)] px-4">
        <div class="card w-full max-w-4xl bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">
                            {{ $accountType->name }}
                        </h1>

                        <p class="mt-1 text-sm text-base-content/60">
                            Account type information and minimum balance requirement.
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

                    <a
                        href="{{ route('account-types.index') }}"
                        class="btn btn-ghost btn-sm"
                    >
                        Back to Account Types
                    </a>

                    <a href="{{ route('accounts.index') }}" class="btn btn-ghost btn-sm">
                        My Accounts
                    </a>
                </div>

                <hr class="h-px my-2 bg-black border-0">

                <div class="rounded-lg bg-[#efefef] px-6 py-5 shadow-lg">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">
                                Name
                            </p>

                            <p class="mt-1 text-lg font-semibold">
                                {{ $accountType->name }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">
                                Code
                            </p>

                            <span class="badge badge-ghost mt-2">
                                {{ strtoupper($accountType->code) }}
                            </span>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow md:col-span-2">
                            <p class="text-sm text-base-content/60">
                                Description
                            </p>

                            <p class="mt-1 font-medium">
                                {{ $accountType->description ?: 'No description available.' }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow md:col-span-2">
                            <p class="text-sm text-base-content/60">
                                Minimum Balance
                            </p>

                            <p class="mt-1 text-2xl font-bold">
                                Rp {{ number_format($accountType->minimum_balance, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>