@aware(['question'])
@props(['parts', 'genuine' => false])

@php
    $partNames = [
        'protocol' => 'protokol',
        'subdomain' => 'alt alan adı',
        'domain' => 'alan adı',
        'path' => 'yol',
    ];
@endphp

{{--
    One practice address in a browser bar. `parts` lists [text, kind] pairs in reading order,
    where kind is protocol, subdomain, domain or path; the domain part names the owner.
--}}
<article data-url-address data-genuine="{{ $genuine ? 'yes' : 'no' }}" class="group/address bg-card border-line overflow-hidden rounded-[1.25rem] border" hidden>
    <div class="border-line bg-paper/60 border-b px-4 pt-3.5 pb-4 sm:px-6">
        <div aria-hidden="true" class="flex gap-1.5">
            <span class="bg-line size-3 rounded-full"></span>
            <span class="bg-line size-3 rounded-full"></span>
            <span class="bg-line size-3 rounded-full"></span>
        </div>

        <div role="group" aria-label="Adres çubuğu" class="bg-card border-line mt-3 flex flex-wrap items-start gap-y-1 rounded-xl border-2 px-3 py-2.5 font-mono text-base group-data-revealed/address:gap-x-2 sm:text-lg">
            @foreach ($parts as [$text, $kind])
                <span class="flex flex-col">
                    <button
                        type="button"
                        data-url-part="{{ $kind }}"
                        class="not-aria-disabled:hover:bg-ink/8 focus-visible:outline-ink data-[state=wrong]:bg-alert/12 data-[state=wrong]:text-alert data-[state=correct]:bg-safe/15 data-[state=correct]:text-safe group-data-revealed/address:not-data-[state]:text-muted rounded-md px-0.5 text-left break-all transition-colors focus-visible:outline-2 data-[state=correct]:font-bold data-[state=wrong]:line-through aria-disabled:cursor-default"
                    >{{ $text }}</button>
                    <span class="text-muted hidden px-0.5 font-sans text-xs font-bold group-data-revealed/address:block">{{ $partNames[$kind] }}</span>
                </span>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col gap-5 px-5 py-5 sm:px-6">
        <div>
            <p data-url-find-prompt tabindex="-1" class="font-bold focus:outline-none">Adresin sahibini gösteren parçaya tıkla.</p>
            <p data-url-find-status aria-live="polite" class="data-[tone=correct]:text-safe data-[tone=wrong]:text-alert mt-2 leading-relaxed font-bold empty:hidden"></p>
        </div>

        <div data-url-judge role="group" aria-label="{{ $question }}" hidden>
            <p data-url-judge-prompt tabindex="-1" class="font-bold focus:outline-none">{{ $question }}</p>
            <div class="mt-3 grid grid-cols-2 gap-3 sm:flex">
                <button type="button" data-judge="yes" class="border-safe text-safe not-aria-disabled:hover:bg-safe/10 aria-pressed:bg-safe aria-pressed:text-card focus-visible:outline-ink rounded-xl border-2 px-4 py-2 font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:not-aria-pressed:opacity-40">
                    Evet, gerçek
                </button>
                <button type="button" data-judge="no" class="border-alert text-alert not-aria-disabled:hover:bg-alert/10 aria-pressed:bg-alert aria-pressed:text-card focus-visible:outline-ink rounded-xl border-2 px-4 py-2 font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default aria-disabled:not-aria-pressed:opacity-40">
                    Hayır, sahte
                </button>
            </div>
        </div>

        <div data-url-feedback class="border-line border-t pt-5" hidden>
            <p data-url-result tabindex="-1" class="font-display data-[tone=correct]:text-safe data-[tone=wrong]:text-alert text-2xl font-extrabold tracking-tight focus:outline-none"></p>
            <div class="mt-2 text-lg leading-relaxed">{{ $slot }}</div>
        </div>
    </div>
</article>
