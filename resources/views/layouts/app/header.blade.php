<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark, scroll-smooth">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header container sticky class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

        {{-- <x-app-logo href="{{ route('dashboard') }}" wire:navigate /> --}}

        <flux:spacer />

        <flux:navbar class="-mb-px max-lg:hidden">
            {{-- <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>
                {{ __('Dashboard') }}
            </flux:navbar.item> --}}

            <flux:navbar.item icon="book-open-text" :href="route('knowledge-base')"
                :current="request()->routeIs('knowledge-base')" wire:navigate>
                {{ __('Knowledge Base')  }}
            </flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">

            <div x-data @keydown.window.prevent.ctrl.k="Flux.modal('global-search').show()"
                @keydown.window.prevent.cmd.k="Flux.modal('global-search').show()">
                <flux:modal.trigger name="global-search">

                    <button type="button"
                        class="hidden md:flex items-center w-full min-w-[260px] bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 hover:border-blue-500 dark:hover:border-blue-500 text-zinc-500 dark:text-zinc-400 px-3 py-2 rounded-lg text-sm transition-colors shadow-sm">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search Knowledge Base...
                        <span
                            class="ml-auto flex items-center gap-1 text-[10px] font-medium border border-zinc-200 dark:border-zinc-700 rounded px-1.5 py-0.5 bg-zinc-50 dark:bg-zinc-900 text-zinc-500 uppercase tracking-widest">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012-2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                            K
                        </span>
                    </button>

                    <button type="button"
                        class="flex md:hidden items-center justify-center w-10 h-10 rounded-lg text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                </flux:modal.trigger>

                <flux:modal name="global-search"
                    class="md:w-[600px] !p-0 overflow-hidden bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800">
                    <livewire:global-search />
                </flux:modal>
            </div>

        </flux:navbar>

        <div x-data>
            <flux:button x-show="!$flux.dark" x-on:click="$flux.dark = true" icon="moon" variant="subtle"
                aria-label="Dark mode" />
            <flux:button x-show="$flux.dark" x-on:click="$flux.dark = false" icon="sun" variant="subtle"
                aria-label="Light mode" />
        </div>

        <x-desktop-user-menu />
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar collapsible="mobile" sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('knowledge-base') }}" wire:navigate />
            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Platform')">


                <flux:sidebar.item icon="book-open-text" :href="route('knowledge-base')"
                    :current="request()->routeIs('knowledge-base')" wire:navigate>
                    {{ __('Knowledge Base')  }}
                </flux:sidebar.item>

            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:spacer />
    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
</body>

</html>


