<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen h-full bg-white dark:bg-zinc-950 antialiased selection:bg-[#0b213f] selection:text-white">

        <div class="min-h-screen flex">

            {{-- ====================== --}}
            {{-- LEFT: MOCS Brand Panel --}}
            {{-- ====================== --}}
            <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] flex-col justify-between
                        bg-[#0b213f] relative overflow-hidden p-12">

                {{-- Decorative background circles --}}
                <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5"></div>
                <div class="absolute -bottom-32 -left-20 w-[28rem] h-[28rem] rounded-full bg-white/5"></div>
                <div class="absolute top-1/2 right-8 w-64 h-64 rounded-full bg-[#dbae5f]/10"></div>

                {{-- Logo --}}
                <div class="relative z-10">
                    <a href="{{ route('home') }}" wire:navigate>
                        <img src="{{ asset('mocswhite.png') }}" alt="MOCS" class="h-10" />
                    </a>
                </div>

                {{-- Center copy --}}
                <div class="relative z-10 space-y-6">
                    <div class="inline-flex items-center gap-2 bg-white/10 text-white/80 text-xs font-semibold uppercase tracking-widest px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#dbae5f]"></span>
                        Knowledge Management
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight tracking-tight">
                        Your team's knowledge,<br/>
                        <span class="text-[#dbae5f]">organized.</span>
                    </h1>
                    <p class="text-white/60 text-lg max-w-sm leading-relaxed">
                        Access standard operating procedures, policies, and documents &mdash; all in one place.
                    </p>
                </div>

                {{-- Bottom footer copy --}}
                <div class="relative z-10 text-white/30 text-xs font-medium">
                    &copy; {{ date('Y') }} MOCS. All rights reserved.
                </div>
            </div>

            {{-- ====================== --}}
            {{-- RIGHT: Form Panel      --}}
            {{-- ====================== --}}
            <div class="flex flex-1 flex-col items-center justify-center px-6 py-12 lg:px-16 
                        bg-gray-50 dark:bg-zinc-950 relative">

                {{-- Theme Toggle --}}
                {{-- <div class="absolute top-4 right-8 z-20">
                    <button type="button" 
                            x-data="{ 
                                isDark: document.documentElement.classList.contains('dark'),
                                toggle() {
                                    this.isDark = !this.isDark;
                                    if (this.isDark) {
                                        document.documentElement.classList.add('dark');
                                        localStorage.setItem('appearance', 'dark');
                                    } else {
                                        document.documentElement.classList.remove('dark');
                                        localStorage.setItem('appearance', 'light');
                                    }
                                }
                            }"
                            @click="toggle()"
                            class="p-2.5 rounded-xl bg-white dark:bg-zinc-900 shadow-sm border border-gray-200 dark:border-zinc-800 text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white transition-all">
                        
                        <svg x-show="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                        </svg>

                        <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                </div> --}}

                {{-- Mobile-only logo --}}
                <div class="lg:hidden mb-12">
                    <a href="{{ route('home') }}" wire:navigate>
                        <img src="{{ asset('mocsblue.png') }}" alt="MOCS" class="h-12 dark:hidden" />
                        <img src="{{ asset('mocswhite.png') }}" alt="MOCS" class="h-12 hidden dark:block" />
                    </a>
                </div>

                <div class="w-full max-w-md">
                    {{-- Form Container with subtle card effect in light mode --}}
                    <div class="bg-white dark:bg-zinc-900/50 p-8 sm:p-10 rounded-2xl shadow-xl lg:shadow-none border border-gray-100 dark:border-zinc-800 lg:border-none lg:bg-transparent dark:lg:bg-transparent">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>

        @fluxScripts
    </body>
</html>
