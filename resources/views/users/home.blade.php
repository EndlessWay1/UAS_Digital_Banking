<x-layout>
    <x-slot:title>
        Home Dashboard
    </x-slot:title>
    <div class="flex justify-center items-center">

        <div class="rounded-lg p-4 flex flex-col bg-base-100 w-3xl shadow-lg gap-4">

            <h1 class="text-3xl font-bold text-center mt-4">Home</h1>


            @can('viewAny', auth()->user())
                <x-feature title="Admin Space">
                    <a href="{{ route('users') }}" class="btn">All User</a>
                    <a href="{{ route('signup') }}" class="btn">Sign Up</a>

                </x-feature>
            @endcan

            <x-feature title="User Space">
                <a href="{{ route('profile', auth()->user(), request()) }}" class="btn">Profile</a>
                <a href="{{ route('signup') }}" class="btn">Sign Up</a>
            </x-feature>

            <x-feature title="Accounts">

                <a href="{{ route('accounts.index') }}" class="btn">My Accounts</a>
                <a href="{{ route('accounts.create') }}" class="btn">Create Account</a>
                <a href="{{ route('account-types.index') }}" class="btn">Account Types</a>
            </x-feature>

            <x-feature title="News/Features">
                <a href="{{ route('news.index') }}" class="btn">News</a>
                <a href="{{ route('news.user.show', auth()->user()) }}" class="btn">My News</a>
                <a href="{{ route('news.create') }}" class="btn">Create News</a>
            </x-feature>
            <x-feature title="Cardless">
                <a href="{{ route('cardless.withdraw.form') }}" class="btn">Withdraw</a>
                <a href="{{ route('cardless.deposit.form') }}" class="btn">Deposits</a>
                <a href="{{ route('cardless.history') }}" class="btn">History Record</a>
            </x-feature>

            <x-feature title="Investments">
                <a href="{{ route('investments.liquidate.form') }}" class="btn">Liquidate</a>
                <a href="{{ route('investments.invest.form') }}" class="btn">Invest</a>
                <a href="{{ route('investments.history') }}" class="btn">Investment History</a>
            </x-feature>

            <x-feature title="Transactions">
                <a href="{{ route('transactions.index') }}" class="btn">Transaction History</a>
                <a href="{{ route('transactions.transfer.form') }}" class="btn">Transfer</a>
                <a href="{{ route('transactions.deposit.form') }}" class="btn">Deposit</a>
                <a href="{{ route('transactions.withdraw.form') }}" class="btn">Withdraw</a>
            </x-feature>

            <x-feature title="Beneficiaries">
                <a href="{{ route('beneficiaries.index') }}" class="btn">Show Beneficiaries</a>
                <a href="{{ route('beneficiaries.create') }}" class="btn">Create Beneficiaries</a>
            </x-feature>


        </div>
    </div>

</x-layout>
