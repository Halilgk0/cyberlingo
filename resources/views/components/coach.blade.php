@props(['color' => null])

{{--
    Bit in the corner of a mission page, cheering right answers and comforting wrong ones.
    On a phone it would cover the text, so there it sits bottom-left, away from the
    right-aligned buttons, and only slides up while reacting.
    It only repeats feedback the page already gives in text, so it is hidden from screen readers.
--}}
<div data-coach aria-hidden="true" class="pointer-events-none fixed bottom-3 left-3 z-40 flex items-end gap-1 transition-transform duration-300 max-sm:translate-y-[140%] max-sm:flex-row-reverse max-sm:data-[active]:translate-y-0 sm:right-6 sm:bottom-6 sm:left-auto">
    <p data-coach-bubble class="bg-card border-line mb-12 max-w-[12rem] translate-y-2 rounded-2xl border-2 max-sm:rounded-bl-sm sm:rounded-br-sm px-3 py-2 text-sm font-extrabold opacity-0 shadow-lg transition-[opacity,translate] duration-200 data-[visible]:translate-y-0 data-[visible]:opacity-100"></p>
    <x-mascot :color="$color" class="size-16 drop-shadow-[0_10px_18px_rgb(0_0_0/0.5)] sm:size-20" />
</div>
