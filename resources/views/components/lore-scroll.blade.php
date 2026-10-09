@props(['title' => 'Biliyor muydun?'])

{{-- A short piece of lore on an old scroll, between the steps of the path. --}}
<aside {{ $attributes->class(['relative mx-auto w-full max-w-md px-1']) }}>
    <span aria-hidden="true" class="absolute inset-x-0 -top-1 h-2.5 rounded-full bg-linear-to-b from-[#7a6440] to-[#3d311d]"></span>
    <div class="rounded-sm border-x border-[#5c4a2c] bg-linear-to-b from-[#2b2218] to-[#1f1912] px-5 py-4 shadow-[0_14px_30px_-18px_rgb(0_0_0/0.9)]">
        <p class="rune-label text-signal flex items-center gap-2 text-xs">
            <x-icons.book class="size-4" /> {{ $title }}
        </p>
        <p class="mt-2 leading-relaxed text-[#d9ccb2]">{{ $slot }}</p>
    </div>
    <span aria-hidden="true" class="absolute inset-x-0 -bottom-1 h-2.5 rounded-full bg-linear-to-b from-[#7a6440] to-[#3d311d]"></span>
</aside>
