@props(['question', 'requirement'])

{{--
    Practice addresses shown one at a time. The learner first clicks the part of the
    address that names its owner, then decides whether the address is the genuine one.
--}}
<div data-url-lab data-requirement="{{ $requirement }}" {{ $attributes }}>
    <div data-url-lab-progress class="text-muted mb-3 flex items-baseline justify-between gap-4">
        <p>Bağlantı <span data-url-lab-position class="text-ink font-bold">1</span> / <span data-url-lab-total></span></p>
        <p>Doğru karar: <span data-url-lab-score class="text-ink font-bold">0</span></p>
    </div>

    <div class="flex flex-col gap-4">
        {{ $slot }}
    </div>

    <div class="mt-4 flex justify-end">
        <button type="button" data-url-lab-next class="btn-primary" hidden>Sonraki bağlantı</button>
    </div>

    <div data-url-lab-summary class="bg-card border-line rounded-[1.25rem] border p-6 sm:p-7" hidden>
        <p data-url-lab-summary-score tabindex="-1" class="font-display text-3xl font-extrabold tracking-tight focus:outline-none"></p>
        <p data-url-lab-summary-message class="mt-2 max-w-[60ch] text-lg leading-relaxed"></p>
        <button type="button" data-url-lab-restart class="btn-secondary mt-5">Baştan başla</button>
    </div>
</div>
