<x-layouts.app title="Siber Şövalye Beratı">
    @if ($isEarned)
        <div class="mx-auto max-w-3xl py-10 sm:py-14">
            <article
                aria-label="Siber Şövalye Beratı"
                class="rise-in relative overflow-hidden rounded-sm bg-[#efe2c4] bg-[radial-gradient(ellipse_at_center,#f5ead2_40%,#d9c49a_100%)] p-3 text-[#3a2a16] shadow-[0_30px_60px_-20px_rgb(0_0_0/0.9)] [print-color-adjust:exact] sm:p-4"
            >
                <div class="border-[3px] border-double border-[#9a7a3a] px-6 py-10 text-center sm:px-12 sm:py-14">
                    <p class="font-rune text-sm font-bold tracking-[0.3em] text-[#7a5a22] uppercase">CyberLingo · Dijital Kale</p>
                    <h1 class="font-display mt-4 text-5xl leading-none font-extrabold sm:text-7xl">Siber Şövalye Beratı</h1>

                    <x-ornament tone="text-[#9a7a3a]" class="mx-auto mt-6 max-w-xs" />

                    <p class="mt-6 text-lg leading-relaxed">Bu berat,</p>
                    <p class="font-display mt-2 text-4xl font-extrabold break-words sm:text-5xl">{{ $learner->name }}</p>
                    <p class="mx-auto mt-4 max-w-[46ch] text-lg leading-relaxed">
                        adlı yolcunun öğrenme yolundaki {{ $completedCount }} görevin hepsini tamamlayarak dijital kalesini
                        katman katman savunmayı öğrendiğini ve <strong class="font-bold">Siber Şövalye</strong> unvanını hak ettiğini belgeler.
                    </p>

                    <dl class="mx-auto mt-8 grid max-w-md grid-cols-3 gap-4 text-sm">
                        <div>
                            <dt class="font-rune text-xs font-bold tracking-widest text-[#7a5a22] uppercase">Tarih</dt>
                            <dd class="mt-1 font-bold">{{ $earnedAt->locale('tr')->translatedFormat('j F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="font-rune text-xs font-bold tracking-widest text-[#7a5a22] uppercase">Unvan</dt>
                            <dd class="mt-1 font-bold">{{ $learner->rank()->title() }}</dd>
                        </div>
                        <div>
                            <dt class="font-rune text-xs font-bold tracking-widest text-[#7a5a22] uppercase">Toplam XP</dt>
                            <dd class="mt-1 font-bold">{{ $learner->totalXp() }}</dd>
                        </div>
                    </dl>

                    <div class="mt-10 flex items-end justify-between gap-4">
                        <x-mascot :color="$learner->avatar_color" mood="cheer" class="size-20 shrink-0" />
                        <p class="font-rune text-xs tracking-widest text-[#7a5a22]">Berat no. CL-{{ str_pad((string) $learner->id, 5, '0', STR_PAD_LEFT) }}</p>
                        <span aria-hidden="true" class="relative grid size-20 shrink-0 place-items-center rounded-full bg-[radial-gradient(circle_at_35%_30%,#b8333f,#7a1522)] text-[#f3cc7a] shadow-[0_4px_10px_rgb(0_0_0/0.4)]">
                            <span class="absolute inset-1.5 rounded-full border-2 border-dashed border-[#f3cc7a]/40"></span>
                            <x-icons.shield class="size-9" />
                        </span>
                    </div>
                </div>
            </article>

            <div class="mt-8 flex flex-wrap justify-center gap-3 print:hidden">
                <button type="button" data-print class="btn-primary">Beratı yazdır</button>
                <a href="{{ route('profile.show') }}" class="btn-secondary">Profilime dön</a>
            </div>
        </div>
    @else
        <div class="mx-auto flex max-w-2xl flex-col items-center py-12 text-center sm:py-16">
            <x-mascot mood="think" :color="$learner->avatar_color" class="size-32" />
            <p class="rune-label text-signal mt-6">Siber Şövalye Beratı</p>
            <h1 class="font-display mt-2 text-5xl font-extrabold">Beratın henüz mühürlenmedi</h1>
            <p class="text-muted mt-4 max-w-[46ch] text-lg leading-relaxed">
                Berat, öğrenme yolundaki bütün görevleri bitiren yolculara verilir. Şu ana kadar {{ $completedCount }} görev tamamladın;
                {{ count($remainingMissions) }} görev kaldı.
            </p>

            <div aria-hidden="true" class="bg-line mt-6 h-3 w-full max-w-md overflow-hidden rounded-full">
                <div class="bg-signal h-full rounded-full" style="width: {{ $completedCount / ($completedCount + count($remainingMissions)) * 100 }}%"></div>
            </div>

            <ol class="mt-8 flex w-full max-w-md flex-col gap-2 text-left">
                @foreach (array_slice($remainingMissions, 0, 5) as $mission)
                    <li class="bg-card border-line flex items-center gap-3 rounded-xl border-2 px-4 py-2.5">
                        <x-dynamic-component :component="$mission->icon()" class="text-muted size-5 shrink-0" />
                        <span class="font-bold">{{ $mission->number() }}. {{ $mission->title() }}</span>
                    </li>
                @endforeach
                @if (count($remainingMissions) > 5)
                    <li class="text-muted px-4 text-sm">ve {{ count($remainingMissions) - 5 }} görev daha</li>
                @endif
            </ol>

            <a href="{{ route('missions.index') }}" class="btn-primary mt-8">Yola devam et</a>
        </div>
    @endif
</x-layouts.app>
