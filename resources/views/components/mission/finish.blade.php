@props(['mission', 'completedBefore' => false, 'signedIn' => false])

<section
    data-finish
    data-complete-url="{{ route('missions.completions.store', $mission) }}"
    aria-labelledby="finish-heading"
    class="bg-card border-line mt-14 rounded-[1.5rem] border-2 p-5 sm:mt-20 sm:p-8"
>
    <div class="flex flex-col items-start gap-4 sm:flex-row sm:justify-between sm:gap-6">
        <div class="min-w-0">
            <h2 id="finish-heading" class="font-display text-3xl font-extrabold tracking-tight">Görevi bitir</h2>
            <p data-finish-status class="text-muted mt-2 sm:text-lg" aria-live="polite">
                Görevi bitirmek için önce yukarıdaki adımları tamamla.
            </p>
            <ul data-finish-remaining class="mt-3 flex list-disc flex-col gap-1 pl-5"></ul>
        </div>

        <span data-finish-stamp class="stamp shrink-0" @unless ($completedBefore) hidden @endunless>Tamamlandı</span>
    </div>

    @if ($completedBefore)
        <p class="text-muted mt-4 leading-relaxed">
            Bu görevi daha önce tamamladın. Tekrar bitirirsen günde bir kez <strong class="text-signal">+{{ \App\Enums\Mission::REPLAY_XP }} XP</strong> kazanırsın ve serin devam eder.
        </p>
    @elseif (! $signedIn)
        <p class="text-muted mt-4 leading-relaxed">
            Hesabın yok mu? Sorun değil, bu görevi deneyebilirsin. Bitirince ilerlemeni kaydetmek için ücretsiz hesap oluşturabilirsin.
        </p>
    @endif

    <div class="mt-6 flex flex-wrap gap-3">
        <button type="button" data-finish-button class="btn-primary w-full px-8 py-4 text-lg sm:w-auto" disabled>Görevi tamamla</button>
    </div>
</section>
