@props(['checked' => false])

{{-- An on/off switch whose slot is its label. Scripts flip `aria-checked` when it is pressed. --}}
<button
    type="button"
    role="switch"
    aria-checked="{{ $checked ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => 'group focus-visible:outline-ink flex items-center justify-between gap-4 rounded-xl text-left font-bold focus-visible:outline-2 focus-visible:outline-offset-4']) }}
>
    <span>{{ $slot }}</span>
    <span aria-hidden="true" class="bg-line group-aria-checked:bg-safe relative h-7 w-12 shrink-0 rounded-full transition-colors">
        <span class="bg-card absolute top-1 left-1 size-5 rounded-full shadow transition-transform group-aria-checked:translate-x-5"></span>
    </span>
</button>
