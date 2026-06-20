<x-layout>
    <x-slot:title>Create Account</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)] px-4">
        <div class="card w-full max-w-4xl bg-base-100 shadow-lg">
            <div class="card-body">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Create New Account</h1>

                        <p class="mt-1 text-sm text-base-content/60">
                            Select an account type and enter the required initial balance.
                        </p>
                    </div>

                    <a href="{{ route('accounts.index') }}" class="btn btn-ghost">
                        Back to Accounts
                    </a>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                        Home
                    </a>

                    <a href="{{ route('account-types.index') }}" class="btn btn-ghost btn-sm">
                        View Account Types
                    </a>
                </div>

                <hr class="h-px my-2 bg-black border-0">

                @if ($errors->any())
                    <div class="alert alert-error">
                        <div>
                            <p class="font-semibold">There are validation errors:</p>

                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="rounded-lg bg-[#efefef] px-6 py-5 shadow-lg">
                    <form
                        method="POST"
                        action="{{ route('accounts.store') }}"
                        class="flex flex-col gap-5"
                    >
                        @csrf

                        <div class="flex flex-col gap-1">
                            <label for="account_type_id" class="text-sm font-semibold">
                                Account Type
                            </label>

                            <select
                                id="account_type_id"
                                name="account_type_id"
                                class="select select-bordered w-full
                                    @error('account_type_id') select-error @enderror"
                                required
                            >
                                <option value="">-- Select Account Type --</option>

                                @foreach ($accountTypes as $type)
                                    <option
                                        value="{{ $type->id }}"
                                        {{ old('account_type_id') == $type->id ? 'selected' : '' }}
                                    >
                                        {{ $type->name }}
                                        — Minimum Balance Rp
                                        {{ number_format($type->minimum_balance, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>

                            @error('account_type_id')
                                <span class="text-xs text-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="initial_balance" class="text-sm font-semibold">
                                Initial Balance
                            </label>

                            <input
                                id="initial_balance"
                                type="number"
                                name="initial_balance"
                                min="0"
                                step="1"
                                value="{{ old('initial_balance', 0) }}"
                                class="input input-bordered w-full
                                    @error('initial_balance') input-error @enderror"
                                required
                            >

                            <span class="text-xs text-base-content/60">
                                Initial balance must meet the selected account type minimum.
                            </span>

                            @error('initial_balance')
                                <span class="text-xs text-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="flex flex-col gap-1">
                                <label for="pin" class="text-sm font-semibold">
                                    PIN
                                </label>

                                <input
                                    id="pin"
                                    type="password"
                                    name="pin"
                                    inputmode="numeric"
                                    maxlength="6"
                                    class="input input-bordered w-full
                                        @error('pin') input-error @enderror"
                                    required
                                >

                                <span class="text-xs text-base-content/60">
                                    PIN must contain exactly 6 digits.
                                </span>

                                @error('pin')
                                    <span class="text-xs text-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label for="pin_confirmation" class="text-sm font-semibold">
                                    Confirm PIN
                                </label>

                                <input
                                    id="pin_confirmation"
                                    type="password"
                                    name="pin_confirmation"
                                    inputmode="numeric"
                                    maxlength="6"
                                    class="input input-bordered w-full"
                                    required
                                >
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 pt-2">
                            <button type="submit" class="btn">
                                Create Account
                            </button>

                            <a href="{{ route('accounts.index') }}" class="btn btn-ghost">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>