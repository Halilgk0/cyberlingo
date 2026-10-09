@props(['categories', 'question', 'requirement'])

{{--
    Scenario cards shown one at a time. The learner files each card under one of the
    `categories` (key => label), and filed cards collect in a bin per category.
--}}
<div data-sorter data-requirement="{{ $requirement }}" {{ $attributes }}>
    <p data-sorter-progress class="text-muted mb-3">
        Olay <span data-sorter-position class="text-ink font-bold">1</span> / <span data-sorter-total></span>
    </p>

    <div class="flex flex-col gap-4">
        {{ $slot }}
    </div>

    <div class="mt-4 flex justify-end">
        <button type="button" data-sorter-next class="btn-primary" hidden>Sonraki olay</button>
    </div>

    <div data-sorter-summary class="bg-card border-line rounded-[1.25rem] border p-6 sm:p-7" hidden>
        <p data-sorter-summary-score tabindex="-1" class="font-display text-3xl font-extrabold tracking-tight focus:outline-none"></p>
        <div class="mt-2 max-w-[60ch] text-lg leading-relaxed">{{ $summary }}</div>
    </div>

    <div class="mt-8 grid gap-3 sm:auto-cols-fr sm:grid-flow-col">
        @foreach ($categories as $category => $label)
            <div data-sorter-bin="{{ $category }}" class="border-line rounded-2xl border-2 border-dashed p-4">
                <p class="flex items-baseline justify-between gap-2">
                    <span class="font-display text-lg font-extrabold tracking-tight">{{ $label }}</span>
                    <span class="text-muted text-sm"><span data-sorter-bin-count>0</span> olay</span>
                </p>
                <ul data-sorter-bin-items class="*:bg-card mt-3 flex flex-col gap-1.5 text-sm font-bold empty:hidden *:rounded-lg *:px-2.5 *:py-1.5"></ul>
            </div>
        @endforeach
    </div>
</div>
