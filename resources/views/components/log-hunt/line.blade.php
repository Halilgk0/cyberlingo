@props(['time', 'ip', 'user', 'evidence' => null, 'why' => null])

{{-- One line of a log hunt. On a phone the time, address and user sit above the event. --}}
<li data-log-line @if ($evidence) data-evidence="{{ $evidence }}" @endif>
    <button
        type="button"
        class="data-[found]:bg-safe/15 data-[state=wrong]:bg-alert/15 focus-visible:outline-rune block w-full rounded-lg px-2 py-1.5 text-left text-xs leading-relaxed transition-colors hover:bg-white/5 focus-visible:outline-2 sm:grid sm:grid-cols-[4.5rem_7.5rem_4.5rem_1fr] sm:gap-x-3 sm:text-sm"
    >
        <span class="flex flex-wrap gap-x-3 sm:contents">
            <span class="text-muted">{{ $time }}</span>
            <span class="text-rune">{{ $ip }}</span>
            <span class="text-signal">{{ $user }}</span>
        </span>
        <span class="block">{{ $slot }}</span>
    </button>
    <div data-log-feedback aria-live="polite" class="data-[tone=correct]:border-safe data-[tone=correct]:bg-safe/10 data-[tone=wrong]:border-alert data-[tone=wrong]:bg-alert/10 mx-1 mt-1 mb-2 rounded-lg border-l-4 px-3 py-2 font-sans text-sm leading-relaxed" hidden></div>
    @if ($why)
        <template data-log-why>{{ $why }}</template>
    @endif
</li>
