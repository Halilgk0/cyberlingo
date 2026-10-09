@props(['label'])

{{-- A phone outline that frames a demo screen. --}}
<div role="group" aria-label="{{ $label }}" {{ $attributes->merge(['class' => 'bg-card border-muted mx-auto w-full max-w-[21rem] overflow-hidden rounded-[2.25rem] border-[6px] shadow-[0_22px_36px_-24px_rgb(16_32_58/0.6)]']) }}>
    <div aria-hidden="true" class="flex justify-center pt-2.5 pb-1">
        <span class="bg-muted h-1.5 w-16 rounded-full"></span>
    </div>
    {{ $slot }}
</div>
