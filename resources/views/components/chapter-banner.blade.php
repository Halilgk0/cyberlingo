@props(['chapter', 'completed', 'total'])

{{-- A chapter's heraldic banner, hanging from a brass rod, with its coat of arms and progress. --}}
<div class="relative pt-1.5">
    <span aria-hidden="true" class="absolute -inset-x-3 top-0 z-10 h-3 rounded-full bg-linear-to-b from-[#f3cc7a] via-[#c99a45] to-[#7a5a22] shadow-[0_3px_6px_rgb(0_0_0/0.6)]">
        <span class="absolute -top-1 -left-1 size-5 rounded-full bg-linear-to-b from-[#f3cc7a] to-[#7a5a22]"></span>
        <span class="absolute -top-1 -right-1 size-5 rounded-full bg-linear-to-b from-[#f3cc7a] to-[#7a5a22]"></span>
    </span>

    <div class="banner bg-(--accent)/60 p-[2px]">
        <div class="banner bg-[color-mix(in_oklab,var(--accent)_14%,#121016)] px-5 pt-6 pb-12 sm:px-7">
            <div class="flex items-start gap-4">
                <span aria-hidden="true" class="relative grid h-[54px] w-12 shrink-0 place-items-center text-[#0c0b0f]">
                    <svg viewBox="0 0 48 54" class="absolute inset-0">
                        <path d="M24 1 47 7v19c0 14-10 23-23 27C11 49 1 40 1 26V7Z" fill="var(--accent)" stroke="#e8b04a" stroke-width="2" />
                    </svg>
                    <x-dynamic-component :component="$chapter->emblem()" class="relative size-6" />
                </span>

                <div class="min-w-0 grow">
                    <p class="rune-label text-(--accent)">Bölüm {{ $chapter->numeral() }}</p>
                    <h2 id="chapter-{{ $chapter->value }}" class="font-display mt-0.5 text-3xl leading-tight font-extrabold sm:text-4xl">{{ $chapter->title() }}</h2>
                    <p class="text-muted mt-1 leading-relaxed">{{ $chapter->summary() }}</p>
                </div>

                <p class="bg-paper/70 font-rune shrink-0 rounded-lg px-2.5 py-1 text-sm font-bold" title="Bu bölümde tamamlanan görevler">
                    {{ $completed }}/{{ $total }}
                </p>
            </div>

            <div aria-hidden="true" class="bg-paper/70 mt-4 h-2.5 overflow-hidden rounded-full">
                <div class="h-full rounded-full bg-(--accent)" style="width: {{ $completed / $total * 100 }}%"></div>
            </div>
        </div>
    </div>
</div>
