@props([
    'verdict',
    'fromName',
    'fromAddress',
    'subject',
    'suspiciousSender' => false,
    'replyTo' => null,
])

{{--
    One message in the practice inbox. `verdict` is either "phishing" or "safe".
    A `reply-to` different from the sender is shown, and marked as a clue once answered.
--}}
<article data-email data-verdict="{{ $verdict }}" class="group/email bg-card border-line overflow-hidden rounded-[1.25rem] border" hidden>
    <header class="border-line border-b px-5 py-4 sm:px-6">
        <h3 data-email-subject tabindex="-1" class="font-sans text-xl leading-snug font-extrabold tracking-tight focus:outline-none sm:text-2xl">{{ $subject }}</h3>
        <dl class="mt-3 grid grid-cols-[auto_1fr] gap-x-3 gap-y-0.5">
            <dt class="text-muted">Kimden</dt>
            <dd class="min-w-0 break-words">
                <span class="font-bold">{{ $fromName }}</span>
                <span @if ($suspiciousSender) data-clue @endif class="text-muted">&lt;{{ $fromAddress }}&gt;</span>
            </dd>
            @if ($replyTo)
                <dt class="text-muted">Yanıtla</dt>
                <dd class="min-w-0 break-words"><span data-clue class="text-muted">&lt;{{ $replyTo }}&gt;</span></dd>
            @endif
            <dt class="text-muted">Kime</dt>
            <dd>ayse.yilmaz@eposta.example</dd>
        </dl>
    </header>

    <div class="flex flex-col gap-3 px-5 py-5 text-lg leading-relaxed sm:px-6">
        {{ $slot }}
    </div>

    <div class="border-line bg-paper/60 flex flex-wrap items-center gap-3 border-t px-5 py-4 sm:px-6">
        <p class="mr-auto font-bold">Bu e-posta sence ne?</p>
        <div class="grid w-full grid-cols-2 gap-3 sm:flex sm:w-auto">
            <button type="button" data-answer="safe" class="border-safe text-safe not-aria-disabled:hover:bg-safe/10 aria-pressed:bg-safe aria-pressed:text-card focus-visible:outline-ink rounded-xl border-2 px-4 py-2 font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:not-aria-pressed:opacity-40">
                Güvenli
            </button>
            <button type="button" data-answer="phishing" class="border-alert text-alert not-aria-disabled:hover:bg-alert/10 aria-pressed:bg-alert aria-pressed:text-card focus-visible:outline-ink rounded-xl border-2 px-4 py-2 font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:not-aria-pressed:opacity-40">
                Oltalama
            </button>
        </div>
    </div>

    <div data-email-feedback class="border-line border-t px-5 py-5 sm:px-6" hidden>
        <p data-email-result tabindex="-1" class="font-display data-[tone=correct]:text-safe data-[tone=wrong]:text-alert text-2xl font-extrabold tracking-tight focus:outline-none"></p>
        <p class="mt-1 font-bold">
            {{ $verdict === 'phishing' ? 'Bu bir oltalama e-postası. Ele veren ipuçları:' : 'Bu e-posta güvenli görünüyor. Çünkü:' }}
        </p>
        <ul class="mt-3 flex list-disc flex-col gap-1.5 pl-5 leading-relaxed">
            {{ $clues }}
        </ul>
    </div>
</article>
