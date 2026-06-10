<x-layout>
    <x-slot:title>
        Sign Up
    </x-slot:title>

    <body>
        <h1>Sign Up</h1>
        <span class="font-medium hover:text-blue-400 text-blue-500"><a href=" {{ route('login') }}">Login</a></span>
        <div class="">

            <div class='max-w-2xl min-w-2xl mx-xl rounded-lg px-2, py-0.5 bg-blue-300'>
                <form method="post" action="{{ route('storeUser') }}" class="flex gap-2">
                    @csrf

                    <span class='' style="font-size: medium;">Name: </span>
                    <input type="text" placeholder="name" id="name" name='name' required autofocus><br>

                    <span style="font-size: medium;">Email: </span>
                    <input type="email" placeholder="email" id="email" name='email' required><br>

                    <span style="font-size: medium;">Password: </span>
                    <input type="password" placeholder="password" name="password" required><br>

                    <button type="submit">Sign Up</button>

                </form>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </body>
</x-layout>
