@props(['prompt', 'code' => null])

{{-- One quiz question. `code` shows a snippet to read before answering, escaped and kept as written. --}}

<div data-question role="group" aria-label="{{ $prompt }}" class="bg-card border-line rounded-2xl border p-5 sm:p-6">
    <p class="text-lg leading-snug font-bold">{{ $prompt }}</p>

    @if ($code)
        <pre class="terminal mt-4 overflow-x-auto text-xs whitespace-pre-wrap [overflow-wrap:anywhere] sm:text-sm sm:whitespace-pre sm:[overflow-wrap:normal]"><code>{{ $code }}</code></pre>
    @endif

    <div class="mt-4 flex flex-col gap-2">
        {{ $slot }}
    </div>

    <p data-question-status aria-live="polite" class="data-[tone=correct]:text-safe data-[tone=wrong]:text-alert mt-3 font-bold empty:hidden"></p>

    <div data-explanation class="border-line mt-3 border-t pt-3 leading-relaxed" hidden>
        {{ $explanation }}
    </div>
</div>
