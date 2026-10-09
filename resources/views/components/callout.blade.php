@props(['title', 'tone' => 'tip'])

<aside {{ $attributes->class([
    'max-w-[65ch] rounded-xl border-l-4 px-5 py-4 leading-relaxed',
    'border-signal bg-signal/15' => $tone === 'tip',
    'border-alert bg-alert/8' => $tone === 'warning',
]) }}>
    <p class="font-bold">{{ $title }}</p>
    <div class="mt-1">{{ $slot }}</div>
</aside>
