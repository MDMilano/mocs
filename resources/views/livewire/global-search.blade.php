<div>
    {{-- Search input bar --}}
    <div class="relative flex items-center px-4 py-1 border-b border-zinc-100 dark:border-zinc-800 bg-white dark:bg-zinc-900 pr-12">
        <svg class="h-4 w-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>

        <input
            wire:model.live.debounce.500ms="query"
            type="text"
            class="w-full border-0 border-transparent bg-transparent py-3.5 pl-3 pr-12 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 dark:placeholder:text-zinc-500 focus:outline-none focus:ring-0 shadow-none [&::-webkit-search-cancel-button]:hidden [&::-ms-clear]:hidden"
            placeholder="Search documents, procedures, or headings..."
            autocomplete="off"
            autofocus
        >

        {{-- Loading spinner --}}
        <div wire:loading wire:target="query" class="absolute right-12 top-1/2 -translate-y-1/2">
            <svg class="animate-spin h-4 w-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>


    </div>

    {{-- Results area --}}
    <div class="max-h-[65vh] min-h-[280px] overflow-y-auto p-3 bg-zinc-50 dark:bg-zinc-900/60 knowledge-base-scroller">

        @if(empty($query))
            {{-- Empty prompt --}}
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <div class="w-12 h-12 mb-4 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 flex items-center justify-center shadow-sm">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Search Knowledge Base</p>
                <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Type a keyword to find documents, SOPs, or headings.</p>
            </div>

        @else
            @forelse($this->results as $result)
                <div
                    class="mb-2 last:mb-0 bg-white dark:bg-zinc-800/80 rounded-lg border border-zinc-100 dark:border-zinc-700/60 shadow-sm overflow-hidden"
                    wire:key="result-{{ $result['id'] }}"
                >
                    {{-- Document title row --}}
                    <a
                        href="{{ route('knowledge-base', ['document' => $result['slug']]) }}"
                        @click="Flux.modal('global-search').close()"
                        class="flex items-center gap-2 px-3 py-2.5 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                    >
                        <svg class="w-4 h-4 shrink-0 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ $result['title'] }}
                    </a>

                    {{-- Matched headings --}}
                    @if(count($result['headings']) > 0)
                        <ul class="border-t border-zinc-100 dark:border-zinc-700/60 divide-y divide-zinc-100 dark:divide-zinc-700/40">
                            @foreach($result['headings'] as $heading)
                                <li wire:key="heading-{{ $result['id'] }}-{{ $heading['id'] }}">
                                    <a
                                        href="{{ route('knowledge-base', ['document' => $result['slug']]) }}#{{ $heading['id'] }}"
                                        @click="Flux.modal('global-search').close()"
                                        class="flex items-center gap-2 px-3 py-2 text-xs text-zinc-500 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                                    >
                                        <span class="text-zinc-300 dark:text-zinc-600 shrink-0">#</span>
                                        <span class="leading-relaxed">{{ $heading['text'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="w-12 h-12 mb-4 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 flex items-center justify-center shadow-sm">
                        <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">No results found</p>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">
                        Nothing matched <span class="text-zinc-700 dark:text-zinc-200 font-medium">"{{ $query }}"</span>
                    </p>
                </div>
            @endforelse
        @endif

    </div>
</div>

