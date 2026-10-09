@props(['href', 'icon', 'active' => false, 'compact' => false])

{{-- A link in the site navigation: a row in the header, or an icon tab in the phone's bottom bar when `compact`. --}}
<a
    href="{{ $href }}"
    @if ($active) aria-current="page" @endif
    {{ $attributes->class([
        'focus-visible:outline-ink flex items-center rounded-xl font-bold transition-colors focus-visible:outline-2',
        'gap-2 px-3 py-2' => ! $compact,
        'flex-1 flex-col gap-0.5 py-1.5 text-xs' => $compact,
        'text-safe bg-safe/10' => $active,
        'text-muted hover:text-ink hover:bg-ink/5' => ! $active,
    ]) }}
>
    <x-dynamic-component :component="$icon" @class(['shrink-0', 'size-5' => ! $compact, 'size-6' => $compact]) />
    {{ $slot }}
</a>
