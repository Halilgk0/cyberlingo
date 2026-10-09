@props(['url', 'suspicious' => false, 'tooltipId' => 'link-'.uniqid()])

{{--
    A link inside a practice email. It never navigates anywhere; hovering, focusing
    or tapping it shows where it would really go, the way a browser's status bar does.
--}}
<span data-fake-link class="group/link relative flex flex-col items-start gap-2">
    <button type="button" aria-describedby="{{ $tooltipId }}" class="bg-ink text-paper focus-visible:outline-ink rounded-lg px-5 py-2.5 font-bold focus-visible:outline-2 focus-visible:outline-offset-2">
        {{ $slot }}
    </button>

    <span
        id="{{ $tooltipId }}"
        role="tooltip"
        class="bg-ink text-paper invisible absolute top-full left-0 z-10 mt-2 w-max max-w-[min(80vw,26rem)] rounded-lg px-3 py-2 text-sm leading-snug shadow-lg group-focus-within/link:visible group-hover/link:visible group-data-open/link:visible"
    >
        Bu bağlantı aslında şuraya gidiyor:
        <span class="block font-bold break-all">{{ $url }}</span>
    </span>

    <span class="text-muted hidden text-base group-data-revealed/email:block">
        Gerçek adres: <span @if ($suspicious) data-clue @endif class="text-ink font-bold break-all">{{ $url }}</span>
    </span>
</span>
