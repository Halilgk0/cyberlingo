@aware(['categories', 'question'])
@props(['answer', 'label'])

{{-- One scenario in a sorter. `answer` is the key of its category; `label` names it once it is filed in a bin. --}}
<article data-sorter-card data-answer="{{ $answer }}" data-label="{{ $label }}" class="bg-card border-line overflow-hidden rounded-[1.25rem] border" hidden>
    <p data-sorter-card-text tabindex="-1" class="px-5 py-6 text-xl leading-relaxed focus:outline-none sm:px-6">{{ $slot }}</p>

    <div role="group" aria-label="{{ $question }}" class="border-line bg-paper/60 border-t px-5 py-4 sm:px-6">
        <p class="font-bold">{{ $question }}</p>

        <div class="mt-3 grid gap-2 sm:auto-cols-fr sm:grid-flow-col">
            @foreach ($categories as $category => $categoryLabel)
                <button
                    type="button"
                    data-choice="{{ $category }}"
                    class="border-line not-aria-disabled:hover:border-ink focus-visible:outline-ink data-[state=correct]:border-safe data-[state=correct]:bg-safe/10 data-[state=wrong]:border-alert data-[state=wrong]:bg-alert/8 rounded-xl border-2 px-4 py-2.5 font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:not-data-[state]:opacity-55"
                >
                    {{ $categoryLabel }}
                </button>
            @endforeach
        </div>

        <p data-sorter-card-status aria-live="polite" class="data-[tone=correct]:text-safe data-[tone=wrong]:text-alert mt-3 font-bold empty:hidden"></p>
    </div>

    <div data-sorter-card-explanation class="border-line border-t px-5 py-5 text-lg leading-relaxed sm:px-6" hidden>
        {{ $explanation }}
    </div>
</article>
