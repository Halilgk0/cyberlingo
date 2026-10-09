@props(['requirement', 'title' => 'Kriz planın'])

{{--
    A crisis plan the learner builds by tapping steps in the order they should happen.
    Steps that share a `stage` may come in any order between them; traps never belong
    in the plan and are crossed out with an explanation when picked. Feedback shows
    right under the tapped step, so it stays in view on a phone.
--}}
<div data-response-plan data-requirement="{{ $requirement }}" {{ $attributes->merge(['class' => 'flex flex-col gap-5']) }}>
    <div class="bg-card border-line rounded-[1.25rem] border-2 p-5 sm:p-6">
        <p class="rune-label text-signal flex items-center justify-between gap-3 text-xs">
            <span>{{ $title }}</span>
            <span class="text-muted"><span data-plan-count>0</span> / <span data-plan-total></span></span>
        </p>
        <p data-plan-empty class="text-muted mt-3">Henüz adım yok. Aşağıdan ilk yapacağın şeyi seç.</p>
        <ol data-plan-list class="mt-4 flex flex-col gap-4 empty:hidden"></ol>
        <p data-plan-announcer aria-live="polite" class="sr-only"></p>
    </div>

    <div data-plan-choices role="group" aria-label="Plana eklenebilecek adımlar">
        <p data-plan-prompt tabindex="-1" class="font-bold focus:outline-none">Sıradaki adım hangisi?</p>
        <ul class="mt-3 flex flex-col gap-2">
            {{ $slot }}
        </ul>
    </div>

    <div data-plan-summary tabindex="-1" class="bg-card border-line rounded-[1.25rem] border p-6 focus:outline-none sm:p-7" hidden>
        <p data-plan-summary-score class="font-display text-2xl font-extrabold tracking-tight"></p>
        <div class="mt-2 max-w-[60ch] leading-relaxed sm:text-lg">{{ $summary }}</div>
    </div>

    <template data-plan-item>
        <li class="rise-in flex gap-3">
            <span data-plan-item-number class="bg-safe grid size-8 shrink-0 place-items-center rounded-full font-extrabold text-[#04210f]"></span>
            <div class="min-w-0">
                <p data-plan-item-label class="leading-snug font-bold"></p>
                <div data-plan-item-why class="text-muted mt-1 leading-relaxed"></div>
            </div>
        </li>
    </template>
</div>
