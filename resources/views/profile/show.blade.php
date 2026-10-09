<x-layouts.app title="Profilim">
    @php
        $rank = $learner->rank();
        $totalXp = $learner->totalXp();
        $dailyXp = $learner->dailyXp(7);
        $chartMax = max(50, ...array_column($dailyXp, 'xp'));
    @endphp

    <section class="bg-card border-line rise-in mt-10 flex flex-col items-center gap-6 rounded-[1.75rem] border-2 p-6 text-center sm:flex-row sm:p-8 sm:text-left">
        <x-mascot :color="$learner->avatar_color" mood="wave" class="size-32 shrink-0" />
        <div class="min-w-0">
            <h1 class="font-display text-4xl font-extrabold tracking-tight break-words">{{ $learner->name }}</h1>
            <p class="text-muted mt-1">{{ $learner->created_at->locale('tr')->translatedFormat('F Y') }} tarihinden beri öğreniyor</p>
            <p class="bg-signal/15 text-signal mt-4 inline-flex rounded-full px-4 py-1.5 font-extrabold">Seviye {{ $rank->level() }} · {{ $rank->title() }}</p>
        </div>
    </section>

    <section aria-label="İstatistikler" class="mt-4 grid grid-cols-2 gap-3 md:grid-cols-4">
        @foreach ([
            ['icons.flame', 'text-[#ff9a3c]', $learner->streak(), 'günlük seri'],
            ['icons.bolt', 'text-signal', $totalXp, 'toplam XP'],
            ['icons.check', 'text-safe', count($learner->completedMissions()).' / '.$missionCount, 'görev tamamlandı'],
            ['icons.trophy', 'text-[#a98bff]', count($earnedAchievements).' / '.count($achievements), 'rozet'],
        ] as [$icon, $iconColor, $value, $label])
            <div data-reveal class="bg-card border-line flex items-center gap-3 rounded-2xl border-2 p-4">
                <x-dynamic-component :component="$icon" @class(['size-9 shrink-0', $iconColor]) />
                <p>
                    <span class="font-display block text-2xl leading-tight font-extrabold">{{ $value }}</span>
                    <span class="text-muted block text-sm font-bold">{{ $label }}</span>
                </p>
            </div>
        @endforeach
    </section>

    <div class="mt-4 grid gap-4 lg:grid-cols-2">
        <section data-reveal aria-labelledby="xp-chart-heading" class="bg-card border-line flex flex-col rounded-[1.5rem] border-2 p-5 sm:p-6">
            <h2 id="xp-chart-heading" class="font-display text-xl font-extrabold">Son 7 günde kazandığın XP</h2>

            <ol aria-hidden="true" class="border-line mt-5 grid min-h-40 grow grid-cols-7 items-end gap-2 border-b-2">
                @foreach ($dailyXp as $day)
                    <li class="group relative flex h-full flex-col justify-end">
                        <span class="bg-card border-line pointer-events-none absolute bottom-full left-1/2 mb-1 -translate-x-1/2 rounded-lg border px-2 py-1 text-xs font-bold whitespace-nowrap opacity-0 transition-opacity group-hover:opacity-100">
                            {{ $day['date']->locale('tr')->isoFormat('dddd') }}: {{ $day['xp'] }} XP
                        </span>
                        <span
                            @class(['rounded-t-[4px]', 'bg-signal' => $day['xp'] > 0, 'bg-line' => $day['xp'] === 0])
                            style="height: {{ $day['xp'] > 0 ? max(6, $day['xp'] / $chartMax * 100) : 3 }}%"
                        ></span>
                    </li>
                @endforeach
            </ol>
            <ol aria-hidden="true" class="text-muted mt-2 grid grid-cols-7 gap-2 text-center text-xs font-bold">
                @foreach ($dailyXp as $day)
                    <li @class(['text-ink' => $loop->last])>{{ $loop->last ? 'Bugün' : $day['date']->locale('tr')->isoFormat('dd') }}</li>
                @endforeach
            </ol>
            <ul class="sr-only">
                @foreach ($dailyXp as $day)
                    <li>{{ $day['date']->locale('tr')->isoFormat('dddd') }}: {{ $day['xp'] }} XP</li>
                @endforeach
            </ul>
        </section>

        <section data-reveal aria-labelledby="rank-heading" class="bg-card border-line rounded-[1.5rem] border-2 p-5 sm:p-6">
            <h2 id="rank-heading" class="font-display text-xl font-extrabold">Seviye yolu</h2>
            <ol class="mt-4 flex flex-col gap-2">
                @foreach (\App\Enums\Rank::cases() as $step)
                    <li @class([
                        'flex items-center gap-3 rounded-xl px-3 py-2',
                        'bg-signal/15' => $step === $rank,
                    ])>
                        <span @class([
                            'grid size-8 shrink-0 place-items-center rounded-full text-sm font-extrabold',
                            'bg-signal text-[#0d121c]' => $step->value <= $totalXp,
                            'bg-line text-muted' => $step->value > $totalXp,
                        ])>{{ $step->level() }}</span>
                        <span @class(['grow font-bold', 'text-muted' => $step->value > $totalXp])>{{ $step->title() }}</span>
                        <span class="text-muted text-sm">{{ $step->value }} XP</span>
                    </li>
                @endforeach
            </ol>
            @if ($rank->next())
                <p class="text-muted mt-3 text-sm font-bold">
                    “{{ $rank->next()->title() }}” olmana {{ $rank->next()->value - $totalXp }} XP kaldı.
                </p>
            @endif
        </section>
    </div>

    <a href="{{ route('certificate') }}" class="border-signal/40 riveted mt-4 flex items-center gap-4 rounded-[1.5rem] border-2 bg-linear-to-r from-[#2b2218] to-[#1f1912] p-5 transition-colors hover:border-signal">
        <span aria-hidden="true" class="grid size-14 shrink-0 place-items-center rounded-full bg-[radial-gradient(circle_at_35%_30%,#b8333f,#7a1522)] text-[#f3cc7a]">
            <x-icons.shield class="size-7" />
        </span>
        <span class="min-w-0 grow">
            <span class="font-display block text-2xl font-extrabold">Siber Şövalye Beratı</span>
            <span class="text-muted block leading-snug">
                {{ count($learner->completedMissions()) === $missionCount ? 'Beratın hazır, mühürlendi! Görüntüle ve yazdır.' : 'Bütün görevleri bitirince mühürlenecek: '.count($learner->completedMissions()).' / '.$missionCount }}
            </span>
        </span>
    </a>

    <section data-reveal aria-labelledby="achievements-heading" class="mt-12">
        <h2 id="achievements-heading" class="font-display text-3xl font-extrabold tracking-tight">Rozetler</h2>
        <ul class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($achievements as $achievement)
                @php($isEarned = in_array($achievement, $earnedAchievements, true))
                <li @class([
                    'flex items-center gap-3 rounded-2xl border-2 p-4',
                    'border-[#a98bff]/50 bg-[#a98bff]/10' => $isEarned,
                    'border-line bg-card' => ! $isEarned,
                ])>
                    <span @class([
                        'grid size-14 shrink-0 place-items-center rounded-2xl text-3xl',
                        'bg-[#a98bff]/20' => $isEarned,
                        'bg-line grayscale opacity-40' => ! $isEarned,
                    ])>{{ $achievement->emoji() }}</span>
                    <span>
                        <span @class(['block font-extrabold', 'text-muted' => ! $isEarned])>{{ $achievement->title() }}</span>
                        <span class="text-muted block text-sm leading-snug">{{ $achievement->description() }}</span>
                        <span class="sr-only">{{ $isEarned ? 'Kazanıldı.' : 'Henüz kazanılmadı.' }}</span>
                    </span>
                </li>
            @endforeach
        </ul>
    </section>

    <section data-reveal aria-labelledby="history-heading" class="mt-12">
        <h2 id="history-heading" class="font-display text-3xl font-extrabold tracking-tight">Tamamlanan görevler</h2>

        @if ($history === [])
            <div class="bg-card border-line mt-5 flex flex-col items-center gap-4 rounded-[1.5rem] border-2 p-8 text-center sm:flex-row sm:text-left">
                <x-mascot mood="think" class="size-24 shrink-0" />
                <div>
                    <p class="font-display text-xl font-extrabold">Henüz bir görev bitirmedin.</p>
                    <p class="text-muted mt-1">İlk görev sadece 5 dakika sürüyor. Hadi başlayalım!</p>
                    <a href="{{ route('missions.index') }}" class="btn-primary mt-4">Öğrenme yoluna git</a>
                </div>
            </div>
        @else
            <ol class="mt-5 flex flex-col gap-2">
                @foreach ($history as $entry)
                    <li class="bg-card border-line flex flex-wrap items-center gap-4 rounded-2xl border-2 p-4" style="--accent: {{ $entry['mission']->chapter()->accent() }}">
                        <span class="grid size-12 shrink-0 place-items-center rounded-full bg-(--accent) text-[#0d121c]">
                            <x-dynamic-component :component="$entry['mission']->icon()" class="size-6" />
                        </span>
                        <div class="min-w-0 grow">
                            <p class="font-bold">{{ $entry['mission']->number() }}. {{ $entry['mission']->title() }}</p>
                            <p class="text-muted text-sm">
                                {{ $entry['firstCompletedAt']->locale('tr')->translatedFormat('j F Y') }}
                                · {{ $entry['plays'] }} kez oynandı · {{ $entry['xp'] }} XP
                            </p>
                        </div>
                        <a href="{{ route('missions.show', $entry['mission']) }}" class="btn-secondary px-3 py-1.5 text-sm">Tekrar oyna</a>
                    </li>
                @endforeach
            </ol>
        @endif
    </section>

    <section data-reveal aria-labelledby="settings-heading" class="mt-12">
        <h2 id="settings-heading" class="font-display text-3xl font-extrabold tracking-tight">Ayarlar</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="bg-card border-line mt-5 flex flex-col gap-6 rounded-[1.5rem] border-2 p-6 sm:p-8">
            @csrf
            @method('PATCH')

            <x-input-field name="name" label="Adın" :value="$learner->name" autocomplete="nickname" maxlength="40" required />

            <fieldset>
                <legend class="font-bold">Bit’in rengi</legend>
                <div class="mt-3 grid grid-cols-3 gap-3 sm:grid-cols-5">
                    @foreach ($avatarColors as $avatarColor)
                        <label class="has-checked:border-safe has-checked:bg-safe/10 border-line focus-within:outline-ink flex cursor-pointer flex-col items-center gap-1 rounded-2xl border-2 p-3 transition-colors focus-within:outline-2 focus-within:outline-offset-2">
                            <input
                                type="radio"
                                name="avatar_color"
                                value="{{ $avatarColor->value }}"
                                class="sr-only"
                                @checked(old('avatar_color', $learner->avatar_color->value) === $avatarColor->value)
                            >
                            <x-mascot :color="$avatarColor" class="size-14" />
                            <span class="text-sm font-bold">{{ $avatarColor->label() }}</span>
                        </label>
                    @endforeach
                </div>
                @error('avatar_color')
                    <p class="text-alert mt-2 font-bold">{{ $message }}</p>
                @enderror
            </fieldset>

            <div>
                <button type="submit" class="btn-primary">Kaydet</button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="btn-secondary w-full sm:w-auto">
                <x-icons.logout class="size-5" /> Çıkış yap
            </button>
        </form>

        <details class="border-alert/40 mt-8 rounded-[1.5rem] border-2 p-6 sm:p-8" @if ($errors->deleteAccount->any()) open @endif>
            <summary class="text-alert cursor-pointer font-extrabold">Hesabımı sil</summary>
            <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4 flex flex-col gap-4">
                @csrf
                @method('DELETE')

                <p class="text-muted leading-relaxed">
                    Hesabın, XP’n, serin ve rozetlerin kalıcı olarak silinir. Bu işlem geri alınamaz.
                    Onaylamak için parolanı yaz.
                </p>
                <x-input-field name="password" type="password" label="Parola" bag="deleteAccount" autocomplete="current-password" required />
                <div>
                    <button type="submit" class="bg-alert rounded-2xl px-5 py-3 font-extrabold text-[#2a0509] shadow-[0_4px_0_#b3303e] transition-[translate,box-shadow] active:translate-y-1 active:shadow-none">
                        Hesabımı kalıcı olarak sil
                    </button>
                </div>
            </form>
        </details>
    </section>
</x-layouts.app>
