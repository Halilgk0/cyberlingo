@props(['mission', 'steps'])

{{--
    A mission page, focused like a lesson: a progress bar instead of the site menu, Bit
    introducing the mission, the steps, and the finish panel. `$learner` and
    `$visitorCompletedMissions` come from a view composer.
--}}
@php
    $avatarColor = $learner?->avatar_color;
    $completedBefore = in_array($mission, $visitorCompletedMissions, true);
    $numerals = ['I', 'II', 'III', 'IV', 'V'];
@endphp

<x-layouts.app :title="$mission->title()" focused>
    <x-slot:header>
        <header class="bg-paper/90 border-line/70 sticky top-0 z-30 border-b backdrop-blur">
            <div class="mx-auto flex max-w-3xl items-center gap-3 px-4 py-3 sm:gap-5 sm:px-6">
                <a href="{{ route('missions.index') }}" data-leave-mission class="text-muted hover:text-ink hover:bg-ink/5 focus-visible:outline-ink -ml-1.5 rounded-xl p-1.5 focus-visible:outline-2" aria-label="Görevden çık, öğrenme yoluna dön">
                    <x-icons.close class="size-7" />
                </a>
                <div data-lesson-progress role="progressbar" aria-label="Görevdeki ilerlemen" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" class="bg-line h-4 grow overflow-hidden rounded-full">
                    <div data-lesson-progress-bar class="bg-safe relative h-full w-[3%] rounded-full transition-[width] duration-700 ease-out">
                        <span aria-hidden="true" class="absolute inset-x-2 top-[3px] h-1 rounded-full bg-white/35"></span>
                    </div>
                </div>
                <button type="button" data-sound-toggle aria-pressed="true" aria-label="Sesi ve titreşimi kapat" class="text-muted hover:text-ink hover:bg-ink/5 focus-visible:outline-ink rounded-xl p-1.5 focus-visible:outline-2">
                    <x-icons.sound class="size-6" />
                </button>
                <p class="text-signal flex shrink-0 items-center gap-1 font-extrabold" title="Bu görevi bitirince kazanacağın XP">
                    <x-icons.bolt class="size-5" />
                    <span class="sr-only">Ödül:</span>
                    {{ $completedBefore ? '+'.\App\Enums\Mission::REPLAY_XP : $mission->xp() }}
                </p>
            </div>
        </header>
    </x-slot:header>

    <div class="mx-auto max-w-3xl">
        <header class="pt-6 pb-10 sm:pt-12 sm:pb-12">
            <p class="rune-label text-signal flex flex-wrap items-center gap-x-2 gap-y-1">
                <span>Görev {{ $mission->number() }} · {{ $mission->chapter()->title() }}</span>
                @unless ($mission->kind() === \App\Enums\MissionKind::Lesson)
                    <span @class([
                        'rounded-md border px-2 py-0.5 text-xs',
                        'border-[#ff8a96]/50 text-[#ff8a96]' => $mission->kind() === \App\Enums\MissionKind::Challenge,
                        'border-signal/50' => $mission->kind() === \App\Enums\MissionKind::Interlude,
                        'border-rune/50 text-rune' => $mission->kind() === \App\Enums\MissionKind::Simulation,
                    ])>{{ $mission->kind()->label() }}</span>
                @endunless
            </p>
            <h1 class="font-display mt-2 text-4xl leading-[1.05] font-extrabold text-balance sm:text-7xl">{{ $mission->title() }}</h1>

            <div class="mt-6 flex items-start gap-3 sm:mt-8 sm:gap-5">
                <x-mascot :color="$avatarColor" mood="wave" class="size-12 shrink-0 sm:size-24" />
                <x-speech-bubble class="mt-1 leading-relaxed sm:mt-3 sm:text-lg">{{ $intro }}</x-speech-bubble>
            </div>

            <nav aria-label="Görev adımları" class="mt-8">
                <ol class="flex flex-wrap gap-2">
                    @foreach ($steps as $stepId => $stepLabel)
                        <li>
                            <a href="#{{ $stepId }}" data-step-link="{{ $stepId }}" class="group/step border-line hover:border-signal focus-visible:outline-ink bg-card/60 data-[done]:border-safe/60 flex items-center gap-2 rounded-full border-2 py-1 pr-3.5 pl-1 text-sm font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 sm:py-1.5 sm:pr-4 sm:pl-1.5 sm:text-base">
                                <span class="bg-signal font-rune group-data-[done]/step:bg-safe grid size-7 place-items-center rounded-full text-xs font-bold text-[#1d1408] transition-colors">
                                    <span class="group-data-[done]/step:hidden">{{ $numerals[$loop->index] ?? $loop->iteration }}</span>
                                    <x-icons.check class="hidden size-4 text-[#04210f] group-data-[done]/step:block" />
                                </span>
                                {{ $stepLabel }}
                                <span data-step-status class="sr-only"></span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </nav>
        </header>

        <div class="flex flex-col gap-14 sm:gap-20">
            {{ $slot }}
        </div>

        <x-mission.finish :mission="$mission" :completed-before="$completedBefore" :signed-in="$learner !== null" />
    </div>

    <x-coach :color="$avatarColor" />
    <x-celebration :color="$avatarColor" />

    {{-- Asks before leaving a mission that has unsaved progress; the close button works without it too. --}}
    <dialog data-leave-dialog aria-labelledby="leave-title" class="bg-card border-line text-ink m-auto w-[calc(100%-2rem)] max-w-sm rounded-[1.5rem] border-2 p-0 backdrop:bg-black/70">
        <div class="flex flex-col items-center p-6 text-center sm:p-7">
            <x-mascot :color="$avatarColor" mood="sad" class="size-20" />
            <h2 id="leave-title" class="font-display mt-3 text-3xl leading-tight font-extrabold">Görevden çıkıyor musun?</h2>
            <p class="text-muted mt-2 leading-relaxed">Bu görevde yaptıkların kaydedilmeyecek. Geri döndüğünde alıştırmalara baştan başlarsın.</p>
            <div class="mt-6 flex w-full flex-col gap-3">
                <button type="button" data-leave-stay class="btn-primary w-full" autofocus>Göreve devam et</button>
                <a href="{{ route('missions.index') }}" class="btn-secondary w-full">Yine de çık</a>
            </div>
        </div>
    </dialog>
</x-layouts.app>
