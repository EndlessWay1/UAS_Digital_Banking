<x-layout>

    <x-slot:title>News</x-slot:title>

    <div class="flex justify-center min-h-[calc(100vh-16rem)]">
        <div class="card w-9/12 bg-base-100 ">
            <div class="card-body">
                <div class="flex justify-between items-center w-full">
                    <h1 class="text-3xl font-bold text-left">News Post</h1>
                    <a class="btn btn-ghost btn-lg" href="{{ route('news.create') }}">Create News</a>
                </div>
                <hr class="h-px my-2 bg-black border-0">

                <div class="flex flex-col gap-3">
                    @forelse ($posts as $post)
                        <div class="rounded-lg bg-[#efefef] px-4 py-2 flex flex-col gap-3 shadow-lg">

                            <div class="flex justify-between w-full">
                                <div class="flex flex-col gap-1">
                                    <a class="text-xl font-bold"
                                        href='{{ route('news.show', $post) }}'>{{ $post->title }}</a>
                                    <div class="flex flex-row gap-2 ml-1">
                                        <span class="text-sm font-semibold mt-1">{{ $post->author->name }}</span>
                                        <span class="text-sm text-base-content/60 mt-1">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                        @if ($post->updated_at->gt($post->created_at->addSeconds(5)))
                                            <span class="text-sm text-base-content/60 italic mt-1">edited</span>
                                        @endif

                                    </div>
                                </div>
                                <div class="flex flex-row gap-2">

                                    @can('update', $post)
                                        <a class="btn btn-ghost btn-sm" href="{{ route('news.edit', $post) }}">Edit</a>
                                        <form action="{{ route('news.destroy', $post) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this news?')"
                                                class="btn btn-ghost btn-sm text-error">
                                                Delete
                                            </button>

                                        </form>
                                    @endcan
                                </div>
                            </div>
                            <p class='text-sm ml-1 max-w-full'
                                style="  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  ">
                                {{ $post->content }}</p>

                        </div>
                    @empty
                        <span>
                            No news for now, check up on it later!
                        </span>
                    @endforelse
                </div>
            </div>


        </div>
    </div>


</x-layout>
