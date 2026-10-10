@use('App\Enums\Mission')
@use('App\Enums\MissionState')

<x-layouts.app>
    @if ($learner)
        <section class="flex flex-wrap items-end justify-between gap-4 pt-10 pb-2 sm:pt-12">
            <div>
                <p class="rune-label text-signal">Hoş geldin, {{ $learner->name }}</p>
                <h1 class="font-display mt-1 text-4xl font-extrabold sm:text-6xl">Öğrenme yolun</h1>
            </div>
            @if ($currentMission)
                <a href="{{ route('missions.show', $currentMission) }}" class="btn-primary">
                    Devam et: {{ $currentMission->title() }}
                </a>
            @endif
        </section>
    @else
        <section class="grid items-center gap-8 pt-10 pb-4 sm:pt-14 md:grid-cols-[1fr_auto]">
            <div>
                <p class="rune-label text-signal">Dijital kaleni savunmayı öğren</p>
                <h1 class="font-display mt-3 max-w-[13ch] text-5xl leading-[0.95] font-extrabold sm:text-8xl">
                    Siber güvenliği oyun gibi öğren.
                </h1>
                <p class="text-muted mt-6 max-w-[52ch] text-lg leading-relaxed">
                    Hiçbir şey bilmeden başla. Her görev birkaç dakikalık bir anlatım ve eğlenceli bir uygulamadan oluşuyor.
                    Görevler sırayla açılıyor; XP topla, serini koru, seviye atla.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('missions.show', Mission::SecurityBasics) }}" class="btn-primary px-7 py-4 text-lg">Hemen başla</a>
                    <a href="{{ route('login') }}" class="btn-secondary px-6 py-3.5">Hesabım var</a>
                </div>
            </div>
            <div class="relative flex items-end justify-center gap-2 md:flex-col md:items-center">
                <span aria-hidden="true" class="torch pointer-events-none absolute bottom-0 left-1/2 size-72 -translate-x-1/2 rounded-full bg-[radial-gradient(circle,rgb(255_138_61/0.28),transparent_65%)]"></span>
                <x-speech-bubble tail="bottom" class="float relative mb-4 max-w-[15rem] font-bold leading-snug">
                    Selam, yolcu! Ben Bit, kalenin bekçisi. Seninle siber güvenliği adım adım öğreneceğiz.
                </x-speech-bubble>
                <x-mascot mood="wave" class="relative size-36 shrink-0 sm:size-48" />
            </div>
        </section>
    @endif

    <div class="mt-10 grid grid-cols-1 items-start gap-14 lg:grid-cols-[minmax(0,1fr)_19rem]">
        <div class="flex flex-col gap-16">
            @foreach ($chapters as $chapter)
                @php
                    $chapterMissions = $chapter->missions();
                    $completedInChapter = collect($chapterMissions)->filter(fn (Mission $mission) => $states[$mission->value] === MissionState::Completed)->count();
                @endphp

                <section data-reveal aria-labelledby="chapter-{{ $chapter->value }}" style="--accent: {{ $chapter->accent() }}">
                    <x-chapter-banner :chapter="$chapter" :completed="$completedInChapter" :total="count($chapterMissions)" />

                    <x-lore-scroll class="mt-8">{{ $chapter->lore() }}</x-lore-scroll>

                    <ol class="mt-16 flex flex-col gap-12">
                        @foreach ($chapterMissions as $mission)
                            <x-path-node :mission="$mission" :state="$states[$mission->value]" :mascot-color="$learner?->avatar_color" />
                        @endforeach
                    </ol>
                </section>
            @endforeach

            <div data-reveal class="flex flex-col items-center pb-6 text-center">
                <x-ornament class="mb-10 w-full max-w-sm" />
                <span class="relative grid size-28 place-items-center">
                    @if ($completedCount === $missionCount)
                        <span aria-hidden="true" class="torch absolute inset-0 rounded-full bg-[radial-gradient(circle,rgb(232_176_74/0.45),transparent_70%)]"></span>
                    @endif
                    <span @class([
                        'relative grid size-24 place-items-center rounded-full',
                        'bg-signal text-[#1d1408] shadow-[0_6px_0_#8a6424]' => $completedCount === $missionCount,
                        'bg-line text-muted shadow-[0_6px_0_#151318]' => $completedCount < $missionCount,
                    ])>
                        <x-icons.castle class="size-12" />
                    </span>
                </span>
                <p class="font-display mt-4 text-3xl font-extrabold">Siber Kale</p>
                <p class="text-muted mt-1 max-w-[32ch]">
                    {{ $completedCount === $missionCount ? 'Bütün görevleri bitirdin. Kale artık senin, Siber Kahraman!' : 'Yolun sonunda kale seni bekliyor. Bütün görevleri bitirince kapıları açılacak.' }}
                </p>
                @if ($learner && $completedCount === $missionCount)
                    <a href="{{ route('certificate') }}" class="btn-primary mt-5">Siber Şövalye Beratını al</a>
                @endif
            </div>
        </div>

        <aside class="flex flex-col gap-4 lg:sticky lg:top-24">
            @if ($learner)
                @php
                    $rank = $learner->rank();
                    $totalXp = $learner->totalXp();
                    $practicedToday = $learner->hasPracticedToday();
                    $goal = \App\Models\User::DAILY_GOAL_XP;
                    $xpToday = $learner->xpEarnedToday();
                    $goalReached = $learner->reachedDailyGoal();
                    $goalPercent = min(100, round($xpToday / $goal * 100));
                    $ringCircumference = 2 * M_PI * 36;
                @endphp

                <section aria-label="Günlük hedef" @class(['riveted relative overflow-hidden rounded-[1.5rem] border-2 p-5', 'bg-safe/10 border-safe/40' => $goalReached, 'bg-card border-line' => ! $goalReached])>
                    <div class="flex items-center gap-4">
                        <div class="relative grid size-20 shrink-0 place-items-center">
                            <svg viewBox="0 0 80 80" class="size-20 -rotate-90" aria-hidden="true">
                                <circle cx="40" cy="40" r="36" fill="none" stroke="currentColor" stroke-width="7" class="text-line" />
                                <circle cx="40" cy="40" r="36" fill="none" stroke-width="7" stroke-linecap="round"
                                    @class(['text-safe' => $goalReached, 'text-signal' => ! $goalReached])
                                    stroke="currentColor"
                                    stroke-dasharray="{{ $ringCircumference }}"
                                    stroke-dashoffset="{{ $ringCircumference * (1 - $goalPercent / 100) }}"
                                    style="transition: stroke-dashoffset 700ms ease" />
                            </svg>
                            <span class="absolute">
                                @if ($goalReached)
                                    <x-icons.check class="text-safe size-8" />
                                @else
                                    <span class="font-display text-signal text-lg leading-none font-extrabold">%{{ $goalPercent }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="min-w-0">
                            <p class="rune-label @if ($goalReached) text-safe @else text-signal @endif text-xs">Günlük hedef</p>
                            <p class="font-display mt-1 text-2xl leading-tight font-extrabold">{{ $xpToday }} / {{ $goal }} XP</p>
                            <p class="text-muted mt-0.5 text-sm leading-snug">
                                {{ $goalReached ? 'Bugünkü hedefini tutturdun, aferin!' : 'Bir görev daha bitir, hedefe yaklaş.' }}
                            </p>
                        </div>
                    </div>
                </section>

                <x-daily-tip />

                <section aria-label="Seviyen" class="bg-card border-line riveted rounded-[1.5rem] border-2 p-5">
                    <div class="flex items-center gap-3">
                        <x-mascot :color="$learner->avatar_color" class="size-16 shrink-0" />
                        <div class="min-w-0">
                            <p class="font-display truncate text-xl font-extrabold">{{ $learner->name }}</p>
                            <p class="text-muted font-bold">Seviye {{ $rank->level() }} · {{ $rank->title() }}</p>
                        </div>
                    </div>
                    <p class="mt-4 flex justify-between gap-2 text-sm font-bold">
                        <span class="text-signal">{{ $totalXp }} XP</span>
                        <span class="text-muted">{{ $rank->next() ? $rank->next()->value.' XP’de '.$rank->next()->title() : 'En yüksek seviye' }}</span>
                    </p>
                    <div aria-hidden="true" class="bg-line mt-1.5 h-3 overflow-hidden rounded-full">
                        <div class="bg-signal h-full rounded-full" style="width: {{ $rank->progressFor($totalXp) }}%"></div>
                    </div>
                    <a href="{{ route('profile.show') }}" class="btn-secondary mt-4 w-full">Profilim</a>
                </section>

                @php($inDanger = $learner->streakInDanger())
                <section aria-label="Günlük seri" @class(['riveted rounded-[1.5rem] border-2 p-5', 'border-alert/50 bg-alert/8' => $inDanger, 'bg-card border-line' => ! $inDanger])>
                    <div class="flex items-center gap-3">
                        <x-icons.flame @class(['size-12 shrink-0', 'flame text-[#ff9a3c]' => $practicedToday, 'text-alert' => $inDanger, 'text-muted' => ! $practicedToday && ! $inDanger]) />
                        <div>
                            <p class="font-display text-3xl font-extrabold">{{ $learner->streak() }} günlük seri</p>
                            <p @class(['text-sm leading-snug', 'text-alert font-bold' => $inDanger, 'text-muted' => ! $inDanger])>
                                {{ $practicedToday ? 'Bugünkü görevini yaptın, harika!' : 'Serini kaybetmemek için bugün bir görev bitir.' }}
                            </p>
                        </div>
                    </div>
                    @if ($inDanger && $currentMission)
                        <a href="{{ route('missions.show', $currentMission) }}" class="btn-primary mt-4 w-full">Serini kurtar: hemen bir görev yap</a>
                    @endif
                    <p class="text-muted mt-3 flex items-center gap-1.5 text-xs leading-snug">
                        <x-icons.shield class="text-rune size-4 shrink-0" /> Seri koruması açık: bir günlük molanı affeder.
                    </p>
                    <ol class="mt-4 grid grid-cols-7 gap-1 text-center">
                        @foreach ($learner->dailyXp(7) as $day)
                            <li class="flex flex-col items-center gap-1">
                                <span class="text-muted text-xs font-bold">{{ $day['date']->locale('tr')->isoFormat('dd') }}</span>
                                <span @class([
                                    'grid size-8 place-items-center rounded-full text-sm font-extrabold',
                                    'bg-[#ff9a3c] text-[#0d121c]' => $day['xp'] > 0,
                                    'bg-line text-muted' => $day['xp'] === 0,
                                ])>
                                    @if ($day['xp'] > 0)
                                        <x-icons.check class="size-4" />
                                        <span class="sr-only">{{ $day['date']->locale('tr')->isoFormat('dddd') }}: görev yapıldı</span>
                                    @else
                                        <span class="sr-only">{{ $day['date']->locale('tr')->isoFormat('dddd') }}: görev yok</span>
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ol>
                </section>

                @php($dueReviews = $learner->dueReviewCount())
                @if ($dueReviews > 0)
                    <a href="{{ route('review.show') }}" class="border-alert/40 bg-alert/8 hover:border-alert riveted flex items-center gap-3 rounded-[1.5rem] border-2 p-5 transition-colors">
                        <x-icons.flame class="text-alert size-10 shrink-0" />
                        <span>
                            <span class="font-display block text-lg font-extrabold">Günün tekrarı · {{ $dueReviews }} soru</span>
                            <span class="text-muted block text-sm leading-snug">Daha önce takıldığın soruları pekiştir, defterini temizle.</span>
                        </span>
                    </a>
                @endif

                <a href="{{ route('leaderboard') }}" class="bg-card border-line hover:border-signal flex items-center gap-3 rounded-[1.5rem] border-2 p-5 transition-colors">
                    <x-icons.trophy class="text-signal size-10 shrink-0" />
                    <span>
                        <span class="font-display block text-lg font-extrabold">Haftalık sıralama</span>
                        <span class="text-muted block text-sm leading-snug">Bu hafta en çok XP toplayanlar arasında yerini gör.</span>
                    </span>
                </a>

                <a href="{{ route('checklist.show') }}" class="bg-card border-line hover:border-rune flex items-center gap-3 rounded-[1.5rem] border-2 p-5 transition-colors">
                    <x-icons.list-check class="text-rune size-10 shrink-0" />
                    <span>
                        <span class="font-display block text-lg font-extrabold">Kale kontrol listesi</span>
                        <span class="text-muted block text-sm leading-snug">
                            {{ count(\App\Enums\ChecklistItem::cases()) }} güvenlik alışkanlığından {{ count($learner->checkedItems()) }} tanesi tamam.
                        </span>
                    </span>
                </a>
            @else
                <x-daily-tip />

                <section aria-labelledby="save-progress-heading" class="bg-card border-line riveted rounded-[1.5rem] border-2 p-5">
                    <div class="flex items-center gap-3">
                        <x-mascot mood="think" class="size-16 shrink-0" />
                        <h2 id="save-progress-heading" class="font-display text-xl leading-tight font-extrabold">İlerlemeni kaydetmek ister misin?</h2>
                    </div>
                    <ul class="mt-4 flex flex-col gap-2.5 font-bold">
                        <li class="flex items-center gap-2"><x-icons.flame class="size-5 shrink-0 text-[#ff9a3c]" /> Günlük serini takip et</li>
                        <li class="flex items-center gap-2"><x-icons.bolt class="text-signal size-5 shrink-0" /> XP topla, seviye atla</li>
                        <li class="flex items-center gap-2"><x-icons.trophy class="size-5 shrink-0 text-[#a98bff]" /> Rozet kazan, sıralamaya gir</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-primary mt-5 w-full">Ücretsiz hesap oluştur</a>
                    <a href="{{ route('login') }}" class="btn-secondary mt-3 w-full">Giriş yap</a>
                </section>
            @endif

            <section aria-label="Genel ilerleme" class="bg-card border-line riveted rounded-[1.5rem] border-2 p-5">
                <p class="flex items-baseline justify-between gap-2">
                    <span class="font-display text-lg font-extrabold">Genel ilerleme</span>
                    <span class="text-muted font-bold">{{ $completedCount }} / {{ $missionCount }} görev</span>
                </p>
                <div aria-hidden="true" class="bg-line mt-2 h-3 overflow-hidden rounded-full">
                    <div class="bg-safe h-full rounded-full" style="width: {{ $completedCount / $missionCount * 100 }}%"></div>
                </div>
                <a href="{{ route('glossary') }}" class="text-muted hover:text-ink mt-4 flex items-center gap-2 text-sm font-bold">
                    <x-icons.book class="size-4" /> Bir terime mi takıldın? Sözlüğe bak.
                </a>
            </section>
        </aside>
    </div>
    {{-- First-visit welcome; onboarding.js opens it once, then remembers in the browser. --}}
    <dialog data-welcome aria-labelledby="welcome-title" class="bg-card border-line text-ink m-auto w-[calc(100%-2rem)] max-w-md rounded-[1.75rem] border-2 p-0 backdrop:bg-black/75" hidden>
        <div class="flex flex-col items-center p-6 text-center sm:p-8">
            <x-mascot mood="wave" class="size-24" />
            <p class="rune-label text-signal mt-4">Ben Bit, kalenin bekçisi</p>
            <h2 id="welcome-title" class="font-display mt-1 text-3xl leading-tight font-extrabold text-balance sm:text-4xl">CyberLingo’ya hoş geldin!</h2>
            <ul class="mt-5 flex w-full flex-col gap-3 text-left">
                <li class="flex items-start gap-3"><x-icons.shield class="text-signal mt-0.5 size-6 shrink-0" /><span class="leading-snug">Siber güvenliği <strong class="font-bold">sıfırdan</strong>, kısa görevlerle öğrenirsin.</span></li>
                <li class="flex items-start gap-3"><x-icons.bolt class="text-signal mt-0.5 size-6 shrink-0" /><span class="leading-snug">Her görevde <strong class="font-bold">XP</strong> kazanır, günlük serini sürdürür, seviye atlarsın.</span></li>
                <li class="flex items-start gap-3"><x-icons.path class="text-signal mt-0.5 size-6 shrink-0" /><span class="leading-snug">Görevler sırayla açılır; <strong class="font-bold">ilkini hesap açmadan</strong> deneyebilirsin.</span></li>
            </ul>
            <button type="button" data-welcome-start class="btn-primary mt-7 w-full py-4 text-lg">Hadi başlayalım</button>
        </div>
    </dialog>
</x-layouts.app>
