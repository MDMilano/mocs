@props([
    'title',
    'description',
])

<div class="flex w-full flex-col gap-1">
    <h2 class="text-2xl font-bold text-[#0b213f]" style="color: #0b213f;">{{ $title }}</h2>
    <p class="text-sm text-gray-500 mt-0.5">{{ $description }}</p>
</div>
