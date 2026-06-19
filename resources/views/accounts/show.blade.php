<x-layout>
    <x-slot:title>Account Detail</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)] px-4">
        <div class="card w-full max-w-5xl bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Account Detail</h1>

                        <p class="mt-1 text-sm text-base-content/60">
                            Complete information for account {{ $account->account_number }}.
                        </p>
                    </div>

                    <a
                        href="{{ route('accounts.balance', $account) }}"
                        class="btn"
                    >
                        View Balance
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

                @if (session('success'))
                    <div class="alert alert-success">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="rounded-lg bg-[#efefef] px-6 py-5 shadow-lg">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">Owner</p>
                            <p class="mt-1 text-lg font-semibold">
                                {{ $account->user->name }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">Account Number</p>
                            <p class="mt-1 text-lg font-semibold">
                                {{ $account->account_number }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">Account Type</p>
                            <p class="mt-1 text-lg font-semibold">
                                {{ $account->accountType->name }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">Balance</p>
                            <p class="mt-1 text-lg font-semibold">
                                Rp {{ number_format($account->balance, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">Status</p>

                            <span
                                class="badge mt-2 {{ $account->status === 'active' ? 'badge-success' : 'badge-ghost' }}"
                            >
                                {{ ucfirst($account->status) }}
                            </span>
                        </div>

                        <div class="rounded-lg bg-base-100 p-4 shadow">
                            <p class="text-sm text-base-content/60">Created At</p>
                            <p class="mt-1 text-lg font-semibold">
                                {{ $account->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>