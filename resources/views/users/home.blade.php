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

        <h2>Accounts</h2>
        <div style="display: flex;flex-direction:row; margin: 1rem 0.5rem">
            <form action="{{ route('accounts.index') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">My Accounts</button>
            </form>

            <form action="{{ route('accounts.create') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">Create Account</button>
            </form>

            <form action="{{ route('account-types.index') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">Account Types</button>
            </form>
        </div>

        <h2>News/Features</h2>
        <div style="display: flex;flex-direction:row; margin: 1rem 0.5rem">
            <form action="{{ route('news.index') }}" method="get">
                <button type="submit" style="background:#58C4DD;color:white">News</button>
            </form>

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

</html>