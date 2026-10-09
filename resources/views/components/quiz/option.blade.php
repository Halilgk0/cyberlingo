@props(['correct' => false])

<button
    type="button"
    data-option
    @if ($correct) data-correct @endif
    class="border-line not-aria-disabled:hover:border-ink focus-visible:outline-ink data-[state=correct]:border-safe data-[state=correct]:bg-safe/10 data-[state=wrong]:border-alert data-[state=wrong]:bg-alert/8 rounded-xl border-2 px-4 py-3 text-left leading-snug transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:not-data-[state]:opacity-55"
>
    {{ $slot }}
</button>
