@props(['tail' => 'left'])

{{-- A speech bubble for the mascot, on dark parchment. `tail` points the bubble at the speaker: left or bottom. --}}
<div {{ $attributes->class(['relative rounded-2xl border-2 border-[#5c4a2c] bg-linear-to-b from-[#2b2218] to-[#211a13] px-4 py-3 text-[#e6dac2]']) }}>
    {{ $slot }}
    <span
        aria-hidden="true"
        @class([
            'absolute size-4 rotate-45 border-[#5c4a2c] bg-[#272017]',
            'top-6 -left-[9px] border-b-2 border-l-2' => $tail === 'left',
            '-bottom-[9px] left-1/2 -translate-x-1/2 border-r-2 border-b-2 bg-[#211a13]' => $tail === 'bottom',
        ])
    ></span>
</div>
