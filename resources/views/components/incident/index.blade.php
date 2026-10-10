@props(['scenario', 'requirement'])

@php
    $startScene = $scenario['scenes'][$scenario['start']];
@endphp

{{--
    A branching incident simulation. The whole scenario is handed to the browser as JSON;
    incident.js runs it as a state machine: each choice locks in, updates the status chips,
    shows its consequence and leads to the next scene, until an ending is reached. The start
    scene is also rendered server-side so the page has content before the script runs.
--}}
<div data-incident data-requirement="{{ $requirement }}" {{ $attributes->merge(['class' => 'flex flex-col gap-5']) }}>
    <script type="application/json" data-incident-data>@json($scenario, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>

    <div class="flex items-center justify-between gap-3">
        <p class="rune-label text-rune flex items-center gap-2 text-xs">
            <x-icons.siren class="size-4" /> Canlı olay
        </p>
        <p class="font-rune text-muted text-sm font-bold tabular-nums">Saat <span data-incident-time class="text-ink">{{ $startScene['time'] }}</span></p>
    </div>

    <div data-incident-status role="status" aria-label="Durum tablosu" class="grid grid-cols-3 gap-2">
        @foreach ($scenario['status'] as $key => $chip)
            <div data-status-chip="{{ $key }}" data-tone="{{ $chip['tone'] }}">
                <p class="rune-label text-muted text-[0.6rem] tracking-wider">{{ $chip['label'] }}</p>
                <p data-status-value>{{ $chip['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div data-incident-scene aria-live="polite" class="bg-card border-line rounded-[1.25rem] border-2 p-5 sm:p-6">
        @if (! empty($startScene['speaker']))
            <p class="text-rune text-sm font-bold">{{ $startScene['speaker'] }}</p>
        @endif
        <p data-incident-text tabindex="-1" class="mt-1 leading-relaxed focus:outline-none sm:text-lg">{{ $startScene['text'] }}</p>
    </div>

    <div data-incident-choices class="flex flex-col gap-2">
        {{-- JS builds the choice buttons here. --}}
    </div>

    <p data-incident-nojs class="text-muted">Bu simülasyon için tarayıcında JavaScript gerekiyor.</p>

    <div data-incident-outcome tabindex="-1" class="rise-in bg-card border-line rounded-[1.5rem] border-2 p-6 focus:outline-none sm:p-8" hidden>
        <p data-outcome-badge class="rune-label"></p>
        <h3 data-outcome-title class="font-display mt-2 text-3xl leading-tight font-extrabold tracking-tight sm:text-4xl"></h3>
        <div data-outcome-text class="mt-3 max-w-[60ch] leading-relaxed sm:text-lg"></div>

        <p class="font-display mt-6 text-lg font-extrabold">Kararların</p>
        <ol data-outcome-log class="mt-3 flex flex-col gap-2"></ol>

        <button type="button" data-incident-replay class="btn-secondary mt-6">Baştan oyna, başka yol dene</button>
    </div>

    <template data-incident-choice>
        <div data-choice>
            <button type="button" class="border-line not-aria-disabled:hover:border-rune focus-visible:outline-rune data-[picked]:border-rune data-[picked]:bg-rune/8 w-full rounded-xl border-2 px-4 py-3 text-left leading-snug font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:not-data-[picked]:opacity-45"></button>
            <div data-choice-feedback class="data-[tone=good]:border-safe data-[tone=good]:bg-safe/10 data-[tone=bad]:border-alert data-[tone=bad]:bg-alert/8 data-[tone=neutral]:border-signal data-[tone=neutral]:bg-signal/10 mt-2 rounded-xl border-l-4 px-4 py-3 leading-relaxed" hidden></div>
        </div>
    </template>
</div>
