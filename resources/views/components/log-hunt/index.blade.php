@props(['requirement'])

{{--
    A log to read like a security analyst. Every line can be tapped: lines that share an
    `evidence` group are one trace of the attack, the rest are ordinary. The learner can
    filter the lines by any text, such as an IP address. `evidence` holds one
    <template data-evidence-why="group"> per group with its explanation.
--}}
<div data-log-hunt data-requirement="{{ $requirement }}" {{ $attributes->merge(['class' => 'flex flex-col gap-4']) }}>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div class="sm:w-80">
            <label for="log-filter" class="font-bold">Kayıtları süz</label>
            <input id="log-filter" data-log-filter type="search" placeholder="Örneğin bir IP adresi" autocomplete="off" autocapitalize="off" spellcheck="false" class="field mt-2 font-mono text-sm">
        </div>
        <p class="text-muted font-bold">Bulunan iz: <span data-log-found class="text-ink">0</span> / <span data-log-total></span></p>
    </div>

    <ol data-log-lines class="terminal flex flex-col gap-0.5 p-2 sm:p-3">
        {{ $slot }}
    </ol>
    <p data-log-empty class="text-muted" hidden>Bu aramaya uyan satır yok.</p>

    {{ $evidence }}

    <div data-log-summary tabindex="-1" class="bg-card border-line rounded-[1.25rem] border p-6 focus:outline-none sm:p-7" hidden>
        <p class="font-display text-2xl font-extrabold tracking-tight">Saldırının izini sürdün</p>
        <div class="mt-2 max-w-[60ch] leading-relaxed sm:text-lg">{{ $summary }}</div>
    </div>
</div>
