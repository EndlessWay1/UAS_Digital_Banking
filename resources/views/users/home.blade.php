<x-layout>
    <x-slot:title>
        Home Dashboard
    </x-slot:title>
    <div class="flex justify-center items-center">

        <div class="rounded-lg p-4 flex flex-col bg-amber-100 w-3xl shadow gap-4">

            <h1 class="text-3xl font-bold text-center mt-4">Home</h1>


            @can('viewAny', auth()->user())
                <div class="rounded-lg bg-amber-50 py-4 px-5 flex flex-col gap-2">
                    <h2 class="text-xl">Admin Space</h2>
                    <div class="flex flex-row gap-3">
                        <a href="{{ route('users') }}" class="btn">All User</a>
                        <a href="{{ route('signup') }}" class="btn">Sign Up</a>
                    </div>
                </div>
            @endcan

            <div class="rounded-lg bg-amber-50 py-4 px-5 flex flex-col gap-2">
                <h2 class="text-xl">User Space</h2>
                <div class="flex flex-row gap-3">
                    <a href="{{ route('profile', auth()->user(), request()) }}" class="btn">Profile</a>
                    <a href="{{ route('signup') }}" class="btn">Sign Up</a>
                </div>
            </div>

            <div class="rounded-lg bg-amber-50 py-4 px-5 flex flex-col gap-2">
                <h2 class="text-xl">Accounts</h2>
                <div class="flex flex-row gap-3">
                    <a href="{{ route('accounts.index') }}" class="btn">My Accounts</a>
                    <a href="{{ route('accounts.create') }}" class="btn">Create Account</a>
                    <a href="{{ route('account-types.index') }}" class="btn">Account Types</a>
                </div>
            </div>

            <div class="rounded-lg bg-amber-50 py-4 px-5 flex flex-col gap-2">
                <h2 class="text-xl">News/Features</h2>
                <div class="flex flex-row gap-3">
                    <a href="{{ route('news.index') }}" class="btn">News</a>
                    <a href="#" class="btn">My News</a>
                    <a href="{{ route('news.create') }}" class="btn">Create News</a>
                </div>
            </div>

            <div class="rounded-lg bg-amber-50 py-4 px-5 flex flex-col gap-2">
                <h2 class="text-xl">Cardless</h2>
                <div class="flex flex-row gap-3">
                    <a href="{{ route('cardless.withdraw.form') }}" class="btn">Withdraw</a>
                    <a href="{{ route('cardless.deposit.form') }}" class="btn">Deposits</a>
                    <a href="{{ route('cardless.history') }}" class="btn">History Record</a>
                </div>
            </div>

            <div class="rounded-lg bg-amber-50 py-4 px-5 flex flex-col gap-2">
                <h2 class="text-xl">Investment</h2>
                <div class="flex flex-row gap-3">
                    <a href="{{ route('investments.liquidate.form') }}" class="btn">Liquidate</a>
                    <a href="{{ route('investments.invest.form') }}" class="btn">Invest</a>
                    <a href="{{ route('investments.history') }}" class="btn">Investment History</a>
                </div>
            </div>

        </div>
    </div>

</x-layout>
