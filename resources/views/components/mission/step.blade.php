@props(['id', 'number', 'title'])

@php
    $numeral = ['1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '5' => 'V'][(string) $number] ?? $number;
@endphp

{{-- One step of a mission, numbered with a Roman numeral on a gold seal. --}}
<section id="{{ $id }}" aria-labelledby="{{ $id }}-heading" data-reveal {{ $attributes->merge(['class' => 'scroll-mt-24']) }}>
    <x-ornament class="mb-6 sm:mb-8" />

    <h2 id="{{ $id }}-heading" class="font-display flex items-center gap-3 text-3xl leading-tight font-extrabold sm:text-4xl">
        <span aria-hidden="true" class="bg-signal font-rune grid size-9 shrink-0 place-items-center rounded-full text-sm font-bold sm:size-11 sm:text-base text-[#1d1408] shadow-[0_3px_0_#8a6424,inset_0_0_0_3px_rgb(0_0_0/0.15)]">{{ $numeral }}</span>
        <span class="sr-only">Adım {{ $number }}:</span>
        {{ $title }}
    </h2>

    <div class="mt-5 sm:mt-6">
        {{ $slot }}
    </div>
</section>
