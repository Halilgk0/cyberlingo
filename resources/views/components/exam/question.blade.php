@props(['prompt', 'topic'])

{{-- One exam question; its options are `x-quiz.option`s and the `explanation` shows after the answer. --}}
<article data-exam-question class="bg-card border-line rounded-[1.25rem] border-2 p-5 sm:p-6" hidden>
    <p class="rune-label text-signal text-xs">{{ $topic }}</p>
    <p data-exam-prompt tabindex="-1" class="mt-2 text-xl leading-snug font-bold focus:outline-none">{{ $prompt }}</p>

    <div role="group" aria-label="{{ $prompt }}" class="mt-4 flex flex-col gap-2">
        {{ $slot }}
    </div>

    <div data-exam-feedback class="border-line mt-4 border-t pt-4" hidden>
        <p data-exam-result aria-live="polite" class="font-display data-[tone=correct]:text-safe data-[tone=wrong]:text-alert text-2xl font-extrabold"></p>
        <div class="mt-1 leading-relaxed">{{ $explanation }}</div>
    </div>
</article>
