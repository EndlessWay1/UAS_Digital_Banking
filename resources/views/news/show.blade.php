<x-layout>

    <x-slot:title>{{ 'News: ' . $news->title }}</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)]">
        <div class="card w-9/12 bg-base-100 ">
            <div class="card-body">
                <div class="flex justify-between w-full items-center">
                    <div>

                        <h1 class="text-3xl font-bold text-left">{{ $news->title }}</h1>
                        <div class="flex justify-between w-full">
                            <div class="flex flex-col gap-1">
                                <div class="flex flex-row gap-2 ml-1">
                                    <span class="text-sm font-semibold mt-1">{{ $news->author->name }}</span>
                                    <span class="text-sm text-base-content/60 mt-1">
                                        {{ $news->created_at->diffForHumans() }}
                                    </span>
                                    @if ($news->updated_at->gt($news->created_at->addSeconds(5)))
                                        <span class="text-sm text-base-content/60 italic mt-1">edited</span>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row gap-1">

                        @can('update', $news)
                            <a class="btn btn-ghost btn-base" href="{{ route('news.edit', $news) }}">Edit</a>
                            <form action="{{ route('news.destroy', $news) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this news?')"
                                    class="btn btn-ghost btn-base text-error">
                                    Delete
                                </button>

                            </form>
                        @endcan
                    </div>
                </div>
                <hr class="h-px my-2 bg-black border-0">
                <div class="flex flex-col gap-3">
                    <div class="rounded-lg bg-[#efefef] px-4 py-2 flex flex-col gap-3 shadow-lg">

                        <p class='text-sm ml-1 max-w-full'>
                            {{ $news->content }}</p>

                    </div>
                </div>
                <div class="ml-3 mt-8">
                    <form action="{{ route('create.comment') }}" method="post">
                        @csrf
                        <input type="hidden" name="news" value="{{ $news->id }}">
                        <span class="text-sm font-semibold ">Write Your Comments:</span>
                        <textarea
                            class="textarea textarea-bordered w-full resize-none 
                            @error('comment') textarea-error @enderror mt-2"
                            name="comment" maxlength="255" required placeholder="Comments..."></textarea>

                        @error('comment')
                            <span class="text-xs mt-0.5 text-error">{{ $message }}</span>
                        @enderror

                        <button type="submit" class="btn btn-base mt-4">Comment</button>
                    </form>
                </div>
                <div class="flex flex-col mt-8 mx-3 gap-2">

                    @forelse ($news->comments as $c)
                        <div class="rounded-lg bg-[#f5f5f5] p-3 shadow flex flex-col gap-1">
                            <div class="flex flex-row w-full justify-between align-center">

                                <span class="text-base font-semibold">{{ $c->user->name }}</span>
                                <span class="text-sm text-base-content/60 mt-1">
                                    {{ $c->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm">{{ $c->comment }}</p>
                        </div>

                    @empty
                        <span>No comments yet, be the first to comment!</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>



</x-layout>
