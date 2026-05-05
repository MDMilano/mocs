<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen h-full bg-white antialiased">

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
                <div class="relative z-10 text-white/30 text-xs">
                    &copy; {{ date('Y') }} MOCS. All rights reserved.
                </div>
            </div>

            {{-- ====================== --}}
            {{-- RIGHT: Form Panel      --}}
            {{-- ====================== --}}
            <div class="flex flex-1 flex-col items-center justify-center px-6 py-12 lg:px-16">

                {{-- Mobile-only logo --}}
                <div class="lg:hidden mb-8">
                    <a href="{{ route('home') }}" wire:navigate>
                        <img src="{{ asset('mocsblue.png') }}" alt="MOCS" class="h-10" />
                    </a>
                </div>

                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>

            </div>
        </div>

        @fluxScripts
    </body>
</html>
