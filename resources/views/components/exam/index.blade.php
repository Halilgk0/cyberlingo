@props(['pass', 'requirement'])

{{--
    An exam: questions one at a time, a single try each, and a pass mark. Below the
    mark the learner restarts; reaching it completes the step. Questions use `x-exam.question`.
--}}
<div data-exam data-pass-score="{{ $pass }}" data-requirement="{{ $requirement }}" {{ $attributes }}>
    <div data-exam-progress class="text-muted mb-3 flex items-baseline justify-between gap-4">
        <p>Soru <span data-exam-position class="text-ink font-bold">1</span> / <span data-exam-total></span></p>
        <p>Doğru: <span data-exam-score class="text-ink font-bold">0</span> · Geçmek için {{ $pass }}</p>
    </div>

    <div aria-hidden="true" class="mb-5 flex gap-1.5">
        <span data-exam-pips class="contents"></span>
    </div>

    <div class="flex flex-col gap-4">
        {{ $slot }}
    </div>

    <div class="mt-4 flex justify-end">
        <button type="button" data-exam-next class="btn-primary" hidden>Sonraki soru</button>
    </div>

    <div data-exam-summary class="bg-card border-line riveted rounded-[1.25rem] border-2 p-6 sm:p-7" hidden>
        <p data-exam-summary-score tabindex="-1" class="font-display text-4xl font-extrabold focus:outline-none"></p>
        <p data-exam-summary-message class="mt-2 max-w-[60ch] text-lg leading-relaxed"></p>
        <button type="button" data-exam-restart class="btn-secondary mt-5">Sınavı baştan başlat</button>
    </div>
</div>
