<x-layouts.app title="Günün tekrarı">
    <div class="mx-auto max-w-2xl py-8 sm:py-12">
        <header class="flex items-start gap-4">
            <div class="min-w-0 grow">
                <p class="rune-label text-signal">Hata defteri</p>
                <h1 class="font-display mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">Günün tekrarı</h1>
                <p class="text-muted mt-3 max-w-[52ch] leading-relaxed sm:text-lg">
                    Daha önce yanlış cevapladığın sorular bir süre sonra burada yeniden karşına çıkar. Doğru bilince soru defterinden silinir.
                </p>
            </div>
            <x-mascot :color="$learner->avatar_color" mood="think" class="hidden size-24 shrink-0 sm:block" />
        </header>

        @if (count($items) > 0)
            <div data-review-session class="mt-8">
                <script type="application/json" data-review-items>@json($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>

                <p class="text-muted mb-3 font-bold">Soru <span data-review-progress class="text-ink"></span></p>

                <div data-review-card class="bg-card border-line rounded-[1.25rem] border-2 p-5 sm:p-6"></div>

                <div data-review-summary tabindex="-1" class="rise-in bg-card border-line rounded-[1.5rem] border-2 p-6 text-center focus:outline-none sm:p-8" hidden>
                    <x-mascot :color="$learner->avatar_color" mood="cheer" class="mx-auto size-24" />
                    <h2 class="font-display mt-3 text-3xl font-extrabold tracking-tight">Tekrar bitti!</h2>
                    <p class="mt-3 leading-relaxed sm:text-lg">
                        <span data-review-cleared class="text-safe font-extrabold">0</span> soruyu doğru bildin ve defterinden sildin.
                        <span data-review-again class="text-alert font-extrabold">0</span> soru yarın tekrar karşına çıkacak.
                    </p>
                    <p data-review-xp-line class="bg-signal/10 border-signal/50 text-signal mt-4 inline-flex items-center gap-1.5 rounded-full border-2 px-4 py-1.5 font-extrabold" hidden>
                        <x-icons.bolt class="size-5" /> +<span data-review-xp>0</span> XP
                    </p>
                    <a href="{{ route('missions.index') }}" class="btn-primary mt-6">Öğrenme yoluna dön</a>
                </div>
            </div>
        @else
            <div class="bg-card border-line riveted mt-8 rounded-[1.5rem] border-2 p-8 text-center">
                <x-mascot :color="$learner->avatar_color" mood="cheer" class="mx-auto size-24" />
                <h2 class="font-display mt-4 text-2xl font-extrabold">Şimdilik tekrar yok</h2>
                <p class="text-muted mx-auto mt-2 max-w-[44ch] leading-relaxed">
                    @if ($laterCount > 0)
                        Defterinde {{ $laterCount }} soru bekliyor; en erken yarın tekrar hazır olacak. Bu arada yeni görevlere devam edebilirsin.
                    @else
                        Yanlış cevapladığın sorular burada toplanır. Henüz tekrar edilecek bir şey yok, harika gidiyorsun!
                    @endif
                </p>
                <a href="{{ route('missions.index') }}" class="btn-primary mt-6">Öğrenme yoluna dön</a>
            </div>
        @endif
    </div>
</x-layouts.app>
