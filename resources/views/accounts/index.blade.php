<x-layout>
    <x-slot:title>My Accounts</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)] px-4">
        <div class="card w-full max-w-6xl bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">My Accounts</h1>
                        <p class="mt-1 text-sm text-base-content/60">
                            Manage and view all of your bank accounts.
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

                    <a href="{{ route('account-types.index') }}" class="btn btn-ghost btn-sm">
                        Account Types
                    </a>
                </div>

                <hr class="h-px my-2 bg-black border-0">

                @if (session('success'))
                    <div class="alert alert-success">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($accounts->count() > 0)
                    <div class="overflow-x-auto rounded-lg bg-[#efefef] shadow-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Account Number</th>
                                    <th>Type</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td class="font-semibold">
                                            {{ $account->account_number }}
                                        </td>

                                        <td>
                                            {{ $account->accountType->name }}
                                        </td>

                                        <td class="font-semibold">
                                            Rp {{ number_format($account->balance, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            <span
                                                class="badge {{ $account->status === 'active' ? 'badge-success' : 'badge-ghost' }}"
                                            >
                                                {{ ucfirst($account->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $account->created_at->format('d M Y') }}
                                        </td>

                                        <td>
                                            <div class="flex flex-wrap gap-2">
                                                <a
                                                    href="{{ route('accounts.show', $account) }}"
                                                    class="btn btn-ghost btn-sm"
                                                >
                                                    Detail
                                                </a>

                                                <a
                                                    href="{{ route('accounts.balance', $account) }}"
                                                    class="btn btn-ghost btn-sm"
                                                >
                                                    Balance
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="rounded-lg bg-[#efefef] px-6 py-10 text-center shadow-lg">
                        <h2 class="text-xl font-bold">No accounts found</h2>

                        <p class="mt-2 text-sm text-base-content/60">
                            Create your first account to start using the banking features.
                        </p>

                        <a href="{{ route('accounts.create') }}" class="btn mt-5">
                            Create Account
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>