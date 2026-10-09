@props(['prompt'])

<div data-question role="group" aria-label="{{ $prompt }}" class="bg-card border-line rounded-2xl border p-5 sm:p-6">
    <p class="text-lg leading-snug font-bold">{{ $prompt }}</p>

    <div class="mt-4 flex flex-col gap-2">
        {{ $slot }}
    </div>

    <p data-question-status aria-live="polite" class="data-[tone=correct]:text-safe data-[tone=wrong]:text-alert mt-3 font-bold empty:hidden"></p>

    <div data-explanation class="border-line mt-3 border-t pt-3 leading-relaxed" hidden>
        {{ $explanation }}
    </div>
</div>
