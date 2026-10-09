@props(['tone' => 'text-signal/45'])

{{-- A thin divider with a diamond in the middle, like a line in an illuminated manuscript; `tone` sets its color. --}}
<div aria-hidden="true" {{ $attributes->class([$tone, 'flex items-center gap-3']) }}>
    <span class="h-px grow bg-linear-to-r from-transparent to-current"></span>
    <svg viewBox="0 0 24 12" class="h-3 w-6 shrink-0">
        <path d="M12 0 16 6 12 12 8 6Z" fill="currentColor" />
        <circle cx="3" cy="6" r="1.5" fill="currentColor" />
        <circle cx="21" cy="6" r="1.5" fill="currentColor" />
    </svg>
    <span class="h-px grow bg-linear-to-l from-transparent to-current"></span>
</div>
