@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand {{ $attributes }}>
        <img src="{{ asset('mocsblue.png') }}" class="h-8 dark:hidden" alt="MOCS" />
        <img src="{{ asset('mocswhite.png') }}" class="h-8 hidden dark:block" alt="MOCS" />
    </flux:sidebar.brand>
@else
    <flux:brand {{ $attributes }}>
        <img src="{{ asset('mocsblue.png') }}" class="h-8 dark:hidden" alt="MOCS" />
        <img src="{{ asset('mocswhite.png') }}" class="h-8 hidden dark:block" alt="MOCS" />
    </flux:brand>
@endif
