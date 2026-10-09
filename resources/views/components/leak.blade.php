@props(['label', 'risk', 'block' => false])

{{--
    A piece of a practice profile that gives away something an attacker could use.
    It is a span (or a div when `block`) acting as a button, so it can wrap across lines
    like the text around it and does not stand out before it is found.
--}}
<{{ $block ? 'div' : 'span' }}
    role="button"
    tabindex="0"
    data-leak
    data-leak-label="{{ $label }}"
    data-leak-risk="{{ $risk }}"
    {{ $attributes->class([
        'hover:bg-ink/6 focus-visible:outline-ink data-[found]:bg-signal/45 data-[hinted]:outline-signal cursor-pointer rounded-sm transition-colors focus-visible:outline-2 data-[found]:cursor-default data-[hinted]:outline-2 data-[hinted]:outline-offset-2 data-[hinted]:outline-dashed',
        'box-decoration-clone px-0.5' => ! $block,
        'block p-1' => $block,
    ]) }}
>{{ $slot }}</{{ $block ? 'div' : 'span' }}>