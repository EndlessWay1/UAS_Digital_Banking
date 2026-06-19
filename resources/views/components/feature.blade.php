@props(['title' => 'Feature'])

<div class="rounded-lg bg-[#efefef] py-4 px-5 flex flex-col gap-2 shadow">
    <h2 class="text-xl">{{ $title }}</h2>
    <div class="flex flex-row gap-3">
        {{ $slot }}

    </div>
</div>
