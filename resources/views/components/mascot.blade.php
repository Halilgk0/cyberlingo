@props(['color' => null, 'mood' => 'happy'])

@php
    $color ??= \App\Enums\AvatarColor::Mint;
@endphp

{{--
    Bit, the app's mascot: a small round knight-robot in a crimson cape, with a glowing
    rune gem on its antenna. `mood` is one of happy, wave, cheer, sad or think; scripts
    change it by setting `data-mood`.
--}}
<svg
    data-mascot
    data-mood="{{ $mood }}"
    viewBox="0 0 120 120"
    aria-hidden="true"
    {{ $attributes->class(['mascot']) }}
    style="--mascot-body: {{ $color->body() }}; --mascot-shade: {{ $color->shade() }};"
>
    <ellipse cx="60" cy="114" rx="32" ry="4.5" fill="#000" opacity="0.4" />

    <g class="mascot-figure">
        <path class="mascot-cape" d="M33 44C20 66 15 92 19 109C40 104 80 104 101 109C105 92 100 66 87 44Z" fill="#6b1d2c" />
        <path class="mascot-cape" d="M33 44C24 62 20 84 21 100C27 90 30 70 38 52Z" fill="#8f2a3c" opacity="0.6" />

        <path class="mascot-arm mascot-arm-left" d="M27 66C15 72 12 82 15 91" fill="none" stroke="var(--mascot-body)" stroke-width="9" stroke-linecap="round" />
        <path class="mascot-arm mascot-arm-right" d="M93 66C105 72 108 82 105 91" fill="none" stroke="var(--mascot-body)" stroke-width="9" stroke-linecap="round" />

        <ellipse cx="46" cy="104" rx="10" ry="6" fill="var(--mascot-shade)" />
        <ellipse cx="74" cy="104" rx="10" ry="6" fill="var(--mascot-shade)" />

        <path d="M60 31V18" stroke="#8a7a5a" stroke-width="4" stroke-linecap="round" />
        <path class="mascot-gem" d="M60 4l6 8-6 8-6-8Z" fill="#5ee6d0" />
        <path d="M60 4l6 8-6 8-6-8Z" fill="none" stroke="#e8b04a" stroke-width="1.5" stroke-linejoin="round" />

        <rect x="22" y="29" width="76" height="75" rx="34" fill="var(--mascot-body)" />
        <path d="M30 46C38 34 82 34 90 46" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" opacity="0.18" />
        <ellipse cx="60" cy="86" rx="22" ry="13" fill="#fff" opacity="0.14" />
        <path d="M60 78l8 2.8v5c0 5-3.4 8-8 9.6-4.6-1.6-8-4.6-8-9.6v-5Z" fill="var(--mascot-shade)" stroke="#e8b04a" stroke-width="1.6" stroke-linejoin="round" />

        <circle cx="34" cy="45" r="3" fill="#e8b04a" />
        <circle cx="86" cy="45" r="3" fill="#e8b04a" />

        <g class="mascot-eyes">
            <ellipse cx="47" cy="58" rx="9.5" ry="10.5" fill="#fff" />
            <ellipse cx="73" cy="58" rx="9.5" ry="10.5" fill="#fff" />
            <circle class="mascot-pupil" cx="48" cy="60" r="5" fill="#0c0b0f" />
            <circle class="mascot-pupil" cx="72" cy="60" r="5" fill="#0c0b0f" />
            <circle cx="50" cy="57.5" r="1.6" fill="#fff" />
            <circle cx="74" cy="57.5" r="1.6" fill="#fff" />
        </g>

        <ellipse cx="35" cy="71" rx="5" ry="3" fill="#ff8fa3" opacity="0.55" />
        <ellipse cx="85" cy="71" rx="5" ry="3" fill="#ff8fa3" opacity="0.55" />

        <path class="mascot-mouth mascot-mouth-happy" d="M53 71q7 7 14 0" fill="none" stroke="#0c0b0f" stroke-width="3.5" stroke-linecap="round" />
        <path class="mascot-mouth mascot-mouth-cheer" d="M51 69q9 14 18 0Z" fill="#0c0b0f" stroke="#0c0b0f" stroke-width="2" stroke-linejoin="round" />
        <path class="mascot-mouth mascot-mouth-sad" d="M53 76q7-6 14 0" fill="none" stroke="#0c0b0f" stroke-width="3.5" stroke-linecap="round" />
        <ellipse class="mascot-mouth mascot-mouth-think" cx="62" cy="73" rx="3" ry="2.6" fill="#0c0b0f" />
    </g>
</svg>
