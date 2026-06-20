<x-layout>

    <x-slot:title>{{ 'Create News' }}</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)]">
        <div class="card w-9/12 bg-base-100 ">
            <div class="card-body">

                <h1 class="text-3xl font-bold text-left">Create News</h1>

                <hr class="h-px my-2 bg-black border-0">
                <div class="flex flex-col gap-3">
                    <div class="rounded-lg bg-[#efefef] px-4 py-2 flex flex-col gap-3 shadow-lg">


                        <form action="{{ route('news.store') }}" method="post">

                            @csrf
                            <div class="flex flex-col gap-0.5 mt-3">
                                <span class="text-sm font-semibold">
                                    News Title
                                </span>
                                <input type="text" name="title" id="title"
                                    class="input @error('title') text-error @enderror" placeholder="News Title">

                                @error('title')
                                    <span class="text-xs mt-0.5 text-error">{{ $message }}</span>
                                @enderror


                            </div>
                            <div class="flex flex-col gap-0.5 mt-4">

                                <span class="text-sm font-semibold ">News Content:</span>
                                <textarea
                                    class="textarea textarea-bordered w-full resize-none min-h-[30vh]
                                @error('content') textarea-error @enderror"
                                    name="content" required placeholder="News Content"></textarea>

                                @error('content')
                                    <span class="text-xs mt-0.5 text-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-base mt-4 mb-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>



</x-layout>
