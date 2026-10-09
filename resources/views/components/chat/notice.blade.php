@props(['from'])

{{-- A phone notification that pops up during a practice chat, such as an SMS arriving. --}}
<div class="border-signal bg-signal/15 w-full max-w-sm self-center rounded-xl border px-4 py-3 text-sm leading-snug">
    <p class="font-bold">Yeni SMS · {{ $from }}</p>
    <p class="mt-1">{{ $slot }}</p>
</div>
