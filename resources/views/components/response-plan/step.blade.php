@props(['stage' => null, 'trap' => false])

{{-- One step to put into a crisis plan. `why` explains it once placed, or why a trap is a trap. --}}
<li data-plan-step @if ($trap) data-trap @else data-stage="{{ $stage }}" @endif>
    <button
        type="button"
        class="border-line not-aria-disabled:hover:border-ink focus-visible:outline-ink data-[state=wrong]:border-alert data-[state=wrong]:bg-alert/8 w-full rounded-xl border-2 px-4 py-3 text-left leading-snug font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:line-through aria-disabled:opacity-60"
    >
        {{ $slot }}
    </button>
    <div data-plan-step-feedback aria-live="polite" class="border-alert bg-alert/8 mt-2 rounded-xl border-l-4 px-4 py-3 leading-relaxed" hidden></div>
    <template data-plan-step-why>{{ $why }}</template>
</li>
