<div class="flex -mt-6 lg:-mt-8 -mb-6 lg:-mb-8 min-h-[calc(100vh-64px)]" x-data="knowledgeBaseData()">

    {{-- ============================================================ --}}
    {{-- LEFT SIDEBAR — document list (desktop: sticky column) --}}
    {{-- ============================================================ --}}
    <aside
        class="hidden lg:flex flex-col w-60 xl:w-64 shrink-0 sticky top-[64px] h-[calc(100vh-64px)] overflow-y-auto knowledge-base-scroller border-r border-gray-200 dark:border-zinc-700 bg-transparent py-6 px-4">
        <h3 class="text-xs font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-5 px-1">Knowledge
            Base</h3>

        @forelse($groupedDocuments as $accountName => $departments)
            <div class="mb-6 last:mb-0">
                <h4 class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-2 px-1">
                    {{ $accountName }}
                </h4>

                @foreach($departments as $departmentName => $docs)
                    <div class="mb-4 last:mb-0">
                        <h5
                            class="text-xs font-semibold text-gray-500 dark:text-zinc-400 mb-1.5 px-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            {{ $departmentName }}
                        </h5>

                        <ul class="space-y-0.5 pl-1 border-l border-zinc-100 dark:border-zinc-800 ml-2">
                            @foreach($docs as $doc)
                                    <li>
                                        <button type="button"
                                            wire:click="selectDocument('{{ $doc->slug }}')"
                                            class="w-full text-left px-2.5 py-1.5 rounded-md transition-colors text-[12.5px] leading-snug
                            {{ $activeDocument?->slug === $doc->slug
                                ? 'bg-[#0b213f]/10 dark:bg-[#0b213f]/40 text-[#0b213f] dark:text-[#6b9fd4] font-semibold'
                                : 'text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-200' }}">
                                            {{ $doc->title }}
                                        </button>
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-sm text-zinc-400 dark:text-zinc-500 px-1">No documents found.</p>
        @endforelse
    </aside>

    {{-- ============================================================ --}}
    {{-- MOBILE SIDEBAR DRAWER --}}
    {{-- ============================================================ --}}
    <div x-data="{ open: false }" class="lg:hidden" @keydown.escape.window="open = false">
        {{-- Floating trigger button (only on mobile/tablet) --}}
        <button @click="open = true" type="button"
            class="fixed bottom-6 left-4 z-40 flex items-center gap-2 bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-100 dark:hover:bg-white text-white dark:text-zinc-900 text-sm font-semibold px-4 py-2.5 rounded-full shadow-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
            Documents
        </button>

        {{-- Backdrop --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
            class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm" style="display:none"></div>

        {{-- Drawer panel --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-72 sm:w-80 bg-white dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 overflow-y-auto knowledge-base-scroller shadow-xl flex flex-col"
            style="display:none">
            {{-- Drawer header --}}
            <div
                class="flex items-center justify-between px-4 py-4 border-b border-gray-100 dark:border-zinc-800 sticky top-0 bg-white dark:bg-zinc-900 z-10">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Knowledge Base</h3>
                <button @click="open = false"
                    class="p-1.5 rounded-lg text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            {{-- Drawer content --}}
            <div class="flex-1 overflow-y-auto px-4 py-4">
                @forelse($groupedDocuments as $accountName => $departments)
                    <div class="mb-6 last:mb-0">
                        <h4
                            class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-2 px-1">
                            {{ $accountName }}
                        </h4>

                        @foreach($departments as $departmentName => $docs)
                            <div class="mb-4 last:mb-0">
                                <h5
                                    class="text-xs font-semibold text-gray-500 dark:text-zinc-400 mb-1.5 px-1 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-zinc-400 dark:text-zinc-600 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                        </path>
                                    </svg>
                                    {{ $departmentName }}
                                </h5>

                                <ul class="space-y-0.5 pl-1 border-l border-zinc-100 dark:border-zinc-800 ml-2">
                                    @foreach($docs as $doc)
                                                    <li>
                                                        <button type="button"
                                                            wire:click="selectDocument('{{ $doc->slug }}')"
                                                            @click="open = false"
                                                            class="w-full text-left px-2.5 py-2 rounded-md transition-colors text-[13px] leading-snug
                                        {{ $activeDocument?->slug === $doc->slug
                                        ? 'bg-[#0b213f]/10 dark:bg-[#0b213f]/40 text-[#0b213f] dark:text-[#6b9fd4] font-semibold'
                                        : 'text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-200' }}">
                                                            {{ $doc->title }}
                                                        </button>
                                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-sm text-zinc-400 dark:text-zinc-500 px-1">No documents found.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================================ --}}
    <main class="flex-1 min-w-0 py-8 px-6 lg:px-12 xl:px-16 overflow-x-hidden">
        <div class="max-w-4xl mx-auto"
             wire:loading.class="opacity-50 transition-opacity duration-200"
             wire:target="selectDocument">
            @if($activeDocument)
            {{-- Document header --}}
            <div class="mb-12 pb-8 border-b border-gray-100 dark:border-zinc-800">
                <div
                    class="flex items-center text-xs text-[#0b213f] dark:text-[#6b9fd4] font-bold uppercase tracking-widest mb-4 gap-2">
                    <span>Knowledge Base</span>
                    <span class="text-[#0b213f]/40 dark:text-[#6b9fd4]/50">/</span>
                    <span>General Documents</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight mb-3">
                    {{ $activeDocument->title }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-zinc-400 flex items-center gap-1.5 font-medium">
                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Last updated on {{ $activeDocument->updated_at->format('M d, Y') }}
                </p>
            </div>

            {{-- Rich content --}}
            <div id="rich-content-area" class="prose prose-slate max-w-none
                                                    text-gray-900 dark:text-zinc-100
                                                    dark:prose-invert
                                                    prose-img:inline prose-img:m-0 prose-img:align-middle prose-img:rounded-lg prose-img:border prose-img:border-gray-200 dark:prose-img:border-zinc-800 prose-img:shadow-sm
                                                    prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-white prose-headings:tracking-tight
                                                    prose-h1:text-4xl prose-h2:text-[32px] prose-h3:text-2xl prose-h4:text-xl
                                                    prose-p:leading-relaxed prose-p:text-[15px] prose-p:text-gray-900 dark:prose-p:text-zinc-100 prose-p:mb-4
                                                    prose-a:text-[#0b213f] dark:prose-a:text-[#6b9fd4] prose-a:font-medium prose-a:no-underline hover:prose-a:underline
                                                    prose-strong:text-gray-900 dark:prose-strong:text-white prose-strong:font-bold
                                                    prose-ul:list-disc prose-ul:pl-5 prose-ol:list-decimal prose-ol:pl-5
                                                    prose-hr:border-gray-100 dark:prose-hr:border-zinc-800 prose-hr:my-12
                                                    prose-headings:scroll-mt-24" wire:key="doc-{{ $activeDocument->id }}">
                {!! $activeDocument->content !!}
            </div>

        @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center h-full min-h-[50vh] text-center px-4">
                <div class="w-16 h-16 mb-5 rounded-2xl bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                    </svg>
                </div>

                @if($documents->isEmpty())
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">No Documents Available</h3>
                    <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1.5 max-w-sm">There are currently no standard
                        operating procedures or documents published.</p>
                @else
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Select a Document</h3>
                    <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1.5 max-w-sm">Choose a document from the sidebar to
                        begin reading.</p>
                @endif
            </div>
        @endif
        </div>
    </main>

    {{-- ============================================================ --}}
    {{-- RIGHT SIDEBAR — table of contents (desktop only) --}}
    {{-- ============================================================ --}}
    @if($activeDocument && !empty($activeDocument->toc))
        <aside
            class="hidden xl:flex flex-col w-56 2xl:w-64 shrink-0 sticky top-[64px] h-[calc(100vh-64px)] overflow-y-auto knowledge-base-scroller border-l border-gray-200 dark:border-zinc-700 bg-transparent py-6 px-4">
            <h3 class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-4 px-1">On This
                Page</h3>
            <ul class="space-y-1 text-[12.5px] pr-1">
                @foreach($activeDocument->toc as $heading)
                    <li>
                        <a href="#{{ $heading['id'] }}"
                            class="block py-1.5 transition-colors duration-150" :class="{
                                                                                            'pl-0': '{{ $heading['level'] }}' === 'H1' || '{{ $heading['level'] }}' === 'H2',
                                                                                            'pl-3': '{{ $heading['level'] }}' === 'H3',
                                                                                            'pl-6': '{{ $heading['level'] }}' === 'H4',
                                                                                            'text-[#0b213f] dark:text-[#6b9fd4] font-bold': activeHeadingId === '{{ $heading['id'] }}',
                                                                                            'text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-zinc-200': activeHeadingId !== '{{ $heading['id'] }}'
                                                                                        }">
                            {{ $heading['text'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>
    @endif

    {{-- ============================================================ --}}
    {{-- IMAGE LIGHTBOX OVERLAY --}}
    {{-- ============================================================ --}}
    <div x-show="showLightbox" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="showLightbox = false"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/95 backdrop-blur-md p-4 lg:p-10"
        style="display: none;"
        x-cloak>
        
        {{-- Close button --}}
        <button @click="showLightbox = false" 
                class="absolute top-6 right-6 z-[110] p-2 text-zinc-400 hover:text-white transition-colors bg-zinc-900/50 rounded-full border border-zinc-800 hover:border-zinc-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- The Image Container --}}
        <div class="relative w-full h-full flex items-center justify-center select-none overflow-auto knowledge-base-scroller" 
            @click="showLightbox = false">
        <img :src="activeImageSrc" 
                @click.stop
                @dblclick="isZoomed = !isZoomed"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                :class="isZoomed ? 'max-w-none scale-[1.5] cursor-zoom-out' : 'max-w-full max-h-full object-contain cursor-zoom-in'"
                class="shadow-2xl rounded-sm ring-1 ring-zinc-800 transition-transform duration-300"
                alt="Enlarged Knowledge Base Image">
        </div>
    </div>

</div>

<script>
    window.knowledgeBaseData = function () {
        return {
            activeHeadingId: null,
            scrollObserver: null,
            
            // Lightbox State
            showLightbox: false,
            activeImageSrc: '',
            isZoomed: false,

            init() {
                this.$nextTick(() => {
                    this.setupScrollSpy();
                    this.setupImages();
                });

                // Re-bind images when the document content updates
                Livewire.on('documentSelected', () => {
                   this.$nextTick(() => {
                       this.setupImages();
                       this.setupScrollSpy();
                       
                       // Scroll back to top
                       window.scrollTo({ top: 0, behavior: 'smooth' });
                   });
                });
            },

            setupImages() {
                const contentArea = document.getElementById('rich-content-area');
                if (!contentArea) return;

                const imgTags = contentArea.querySelectorAll('img');

                imgTags.forEach((img) => {
                    // 1. Detect small icons and style them differently
                    // We increase threshold to 160px and also check if it's within text
                    const isSmall = (w, h) => (w < 160 && h < 160);
                    
                    const applyIconStyles = () => {
                        const naturalW = img.naturalWidth;
                        const naturalH = img.naturalHeight;
                        const parentText = img.parentElement ? img.parentElement.textContent.trim() : '';
                        
                        // If it's small OR it's a square-ish image inside a paragraph with other text
                        if (isSmall(naturalW, naturalH) || (naturalW < 250 && naturalW/naturalH < 1.5 && parentText.length > 0)) {
                            img.classList.add('kb-inline-icon');
                            img.style.cursor = 'default';
                            img.onclick = null;
                            return true;
                        }
                        return false;
                    };

                    if (img.complete) {
                        if (applyIconStyles()) return;
                    } else {
                        img.onload = () => { applyIconStyles(); };
                    }

                    // 2. Style and click handler for larger images (screenshots)
                    img.style.cursor = 'zoom-in';
                    img.classList.add('kb-screenshot', 'transition-all', 'duration-200', 'hover:brightness-110', 'hover:ring-2', 'hover:ring-[#0b213f]/30', 'active:scale-[0.98]');
                    
                    img.onclick = () => {
                        this.activeImageSrc = img.src;
                        this.isZoomed = false;
                        this.showLightbox = true;
                    };
                });
            },

            setupScrollSpy() {
                if (this.scrollObserver) {
                    this.scrollObserver.disconnect();
                }

                const contentArea = document.getElementById('rich-content-area');
                if (!contentArea) return;

                const tags = contentArea.querySelectorAll('h1, h2, h3, h4');

                this.scrollObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.activeHeadingId = entry.target.id;
                        }
                    });
                }, { rootMargin: '-10% 0px -80% 0px', threshold: 0 });

                tags.forEach((tag) => {
                    this.scrollObserver.observe(tag);

                    if (!tag.querySelector('.heading-anchor') && tag.id) {
                        tag.classList.add('group', 'relative');

                        const anchor = document.createElement('a');
                        anchor.href = '#' + tag.id;
                        anchor.innerHTML = '#';
                        anchor.title = 'Copy link to clipboard';
                        anchor.className = 'heading-anchor absolute -left-6 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 text-zinc-300 dark:text-zinc-600 hover:text-amber-600 dark:hover:text-amber-500 font-normal no-underline transition-all duration-200 cursor-pointer';

                        anchor.addEventListener('click', (e) => {
                            e.preventDefault();
                            const url = window.location.origin + window.location.pathname + window.location.search + '#' + tag.id;

                            if (navigator.clipboard && window.isSecureContext) {
                                navigator.clipboard.writeText(url);
                            } else {
                                const textArea = document.createElement("textarea");
                                textArea.value = url;
                                textArea.style.position = "absolute";
                                textArea.style.left = "-999999px";
                                document.body.prepend(textArea);
                                textArea.select();
                                try { document.execCommand('copy'); } catch (error) { } finally { textArea.remove(); }
                            }

                            history.pushState(null, null, '#' + tag.id);

                            anchor.innerHTML = '✓';
                            anchor.classList.add('text-green-500');
                            anchor.classList.remove('text-gray-300', 'dark:text-zinc-600');

                            setTimeout(() => {
                                anchor.innerHTML = '#';
                                anchor.classList.remove('text-green-500');
                                anchor.classList.add('text-gray-300', 'dark:text-zinc-600');
                            }, 1500);
                        });

                        tag.prepend(anchor);
                    }
                });

                if (tags.length > 0 && !this.activeHeadingId) {
                    this.activeHeadingId = tags[0].id;
                }
            }
        };
    };
</script>
