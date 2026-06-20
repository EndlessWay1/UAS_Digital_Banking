<x-layout>
    <x-slot:title>Account Balance</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)] px-4">
        <div class="card w-full max-w-4xl bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Account Balance</h1>

                        <p class="mt-1 text-sm text-base-content/60">
                            Current balance information for your account.
                        </p>
                    </div>

                    <a
                        href="{{ route('accounts.show', $account) }}"
                        class="btn btn-ghost"
                    >
                        Account Detail
                    </a>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                        Home
                    </a>

                    <a href="{{ route('accounts.index') }}" class="btn btn-ghost btn-sm">
                        Back to Accounts
                    </a>
                </div>

                <hr class="h-px my-2 bg-black border-0">

                <div class="rounded-lg bg-[#efefef] px-6 py-6 shadow-lg">
                    <div class="rounded-lg bg-base-100 p-6 text-center shadow">
                        <p class="text-sm font-semibold text-base-content/60">
                            Current Balance
                        </p>

                        <p class="mt-3 text-4xl font-bold">
                            Rp {{ number_format($account->balance, 0, ',', '.') }}
                        </p>

                        <div class="mt-5 flex flex-wrap justify-center gap-3">
                            <span class="badge badge-lg">
                                {{ $account->accountType->name }}
                            </span>

                            <span
                                class="badge badge-lg {{ $account->status === 'active' ? 'badge-success' : 'badge-ghost' }}"
                            >
                                {{ ucfirst($account->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">
                                Account Number
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $account->account_number }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">
                                Account Type
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $account->accountType->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>