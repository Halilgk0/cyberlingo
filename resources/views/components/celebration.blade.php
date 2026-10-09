@props(['color' => null])

{{--
    The screen shown after finishing a mission. It starts empty; the finish panel fills it
    with what the server returned (XP, streak, rank, new badges, the next mission).
--}}
<div data-celebration role="dialog" aria-modal="true" aria-labelledby="celebration-title" class="bg-paper/95 fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm" hidden>
    <div data-confetti aria-hidden="true" class="pointer-events-none fixed inset-0 overflow-hidden"></div>

    <div class="relative mx-auto flex min-h-full max-w-md flex-col items-center justify-center px-4 py-10 text-center">
        <span class="relative">
            <span aria-hidden="true" class="torch absolute -inset-10 rounded-full bg-[radial-gradient(circle,rgb(232_176_74/0.3),transparent_65%)]"></span>
            <x-mascot :color="$color" mood="cheer" class="relative size-36" />
        </span>

        <p class="rune-label text-signal rise-in mt-4">Zafer!</p>

        <h2 id="celebration-title" tabindex="-1" class="font-display rise-in mt-1 text-4xl leading-tight font-extrabold sm:text-5xl focus:outline-none">Görev tamamlandı!</h2>
        <p data-celebration-subtitle class="text-muted rise-in mt-2 text-lg"></p>

        <div class="rise-in mt-7 grid w-full grid-cols-2 gap-3 [animation-delay:120ms]">
            <div class="border-signal/60 bg-signal/10 rounded-2xl border-2 p-4">
                <p class="text-signal text-sm font-extrabold tracking-wide uppercase">Kazanılan XP</p>
                <p class="font-display mt-1 flex items-center justify-center gap-1 text-4xl font-extrabold">
                    <x-icons.bolt class="text-signal size-8" />
                    <span data-celebration-xp>0</span>
                </p>
            </div>
            <div data-celebration-streak-card class="rounded-2xl border-2 border-[#ff9a3c]/60 bg-[#ff9a3c]/10 p-4">
                <p class="text-sm font-extrabold tracking-wide text-[#ff9a3c] uppercase">Seri</p>
                <p class="font-display mt-1 flex items-center justify-center gap-1 text-4xl font-extrabold">
                    <x-icons.flame class="flame size-8 text-[#ff9a3c]" />
                    <span data-celebration-streak>0</span>
                </p>
            </div>
        </div>

        <div data-celebration-rank class="bg-card border-line riveted rise-in mt-3 w-full rounded-2xl border-2 p-4 text-left [animation-delay:220ms]">
            <p class="flex items-baseline justify-between gap-3">
                <span class="font-extrabold">Seviye <span data-celebration-level></span>: <span data-celebration-rank-title></span></span>
                <span data-celebration-rank-next class="text-muted text-sm"></span>
            </p>
            <div class="bg-line mt-2 h-3 overflow-hidden rounded-full">
                <div data-celebration-rank-bar class="bg-signal h-full w-0 rounded-full transition-[width] delay-300 duration-1000 ease-out"></div>
            </div>
            <p data-celebration-rank-up class="text-signal mt-2 font-extrabold" hidden></p>
        </div>

        <ul data-celebration-achievements class="mt-3 flex w-full flex-col gap-2 empty:hidden"></ul>

        <div data-celebration-guest class="bg-card border-line mt-3 w-full rounded-2xl border-2 p-5 text-left" hidden>
            <p class="font-display text-xl font-extrabold">İlerlemen kaybolmasın!</p>
            <p class="text-muted mt-1 leading-relaxed">Ücretsiz bir hesap oluştur; bu görevin XP’si hesabına aktarılsın ve sıradaki görevin kilidi açılsın.</p>
        </div>

        <div class="rise-in mt-7 flex w-full flex-col gap-3 [animation-delay:320ms]">
            <a data-celebration-primary href="{{ route('missions.index') }}" class="btn-primary w-full py-4 text-lg">Devam et</a>
            <a data-celebration-secondary href="{{ route('missions.index') }}" class="btn-secondary w-full">Öğrenme yoluna dön</a>
        </div>

        <template data-celebration-achievement>
            <li class="rise-in flex items-center gap-3 rounded-2xl border-2 border-[#a98bff]/60 bg-[#a98bff]/10 p-3 text-left">
                <span data-achievement-emoji class="grid size-12 shrink-0 place-items-center rounded-xl bg-[#a98bff]/20 text-2xl"></span>
                <span>
                    <span class="block text-sm font-extrabold tracking-wide text-[#a98bff] uppercase">Yeni rozet</span>
                    <span data-achievement-title class="block font-extrabold"></span>
                    <span data-achievement-description class="text-muted block text-sm"></span>
                </span>
            </li>
        </template>
    </div>
</div>
