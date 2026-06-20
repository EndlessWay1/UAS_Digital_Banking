<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Dashboard</title>
</head>

<body>
    <h1>Home</h1>
    <div style="display: flex; flex-direction:column; margin:1rem">
        <h2>User Space</h2>
        <div style="display: flex;flex-direction:row; margin: 1rem 0.5rem">
            <form action="{{ route('profile', request()) }}" method="get">
                @csrf
                <button type="submit" style="background:#58C4DD;color:white">Profile</button>
            </form>

            <form action="{{ route('signup') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">Sign Up</button>
            </form>
        </div>

        <h2>News/Features</h2>
        <div style="display: flex;flex-direction:row; margin: 1rem 0.5rem">
            <form action="{{ route('news.index') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">News</button>
            </form>
            <!-- TODO -->
            <button type="submit" style="background:#58C4DD;color:white">My News</button>
            <form action="{{ route('news.create') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">Create News</button>
            </form>
        </div>
        <h2>Cardless</h2>
        <div style="display: flex;flex-direction:row; margin: 1rem 0.5rem">
            <form action="{{ route('cardless.withdraw.form') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">Withdraw</button>
            </form>
            <form action="{{ route('cardless.deposit.form') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">Deposits</button>
            </form>
            <form action="{{ route('cardless.history') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">Transactions History</button>
            </form>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Log Out</button>
    </form>
</body>


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

            <x-feature title="Savings Pocket">
                <a href="{{ route('pocket.index') }}" class="btn">Show Saving Pockets</a>
                <a href="{{ route('pocket.create') }}" class="btn">Create A Pocket</a>
            </x-feature>


        </div>
    </div>

</x-layout>
