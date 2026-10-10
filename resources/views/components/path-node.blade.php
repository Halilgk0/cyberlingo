@props(['mission', 'state', 'mascotColor' => null])

@use('App\Enums\MissionKind')
@use('App\Enums\MissionState')

@php
    /* The path winds left and right like a trail; the pattern repeats every eight nodes. */
    $offsets = [0, 1, 1.5, 1, 0, -1, -1.5, -1];
    $offset = $offsets[($mission->number() - 1) % count($offsets)];
    $kind = $mission->kind();
    $isLocked = $state === MissionState::Locked;
    $stateLabel = match ($state) {
        MissionState::Completed => 'tamamlandı',
        MissionState::Current => 'sıradaki görev',
        MissionState::Locked => 'kilitli',
    };
    $label = "Görev {$mission->number()}, {$kind->label()}: {$mission->title()} ({$stateLabel})";

    /* A dragon trial is a crimson shield; locked missions are cold stone. */
    $face = match (true) {
        $isLocked => '#2b2730',
        $kind === MissionKind::Challenge => '#c2384a',
        default => 'var(--accent)',
    };
    $deep = $isLocked ? '#151318' : "color-mix(in oklab, {$face} 50%, black)";
@endphp

{{--
    One mission on the learning path. Lessons are shields, interludes are round rune
    stones, and a dragon trial is a large crowned shield. The chapter sets `--accent`.
--}}
<li class="flex w-full justify-center" data-path-node="{{ $state->value }}" data-kind="{{ $kind->value }}">
    <div
        class="node-pop relative flex translate-x-[calc(var(--offset)*44px)] flex-col items-center sm:translate-x-[calc(var(--offset)*64px)]"
        style="--offset: {{ $offset }}; animation-delay: {{ $mission->number() * 60 }}ms"
    >
        @if ($state === MissionState::Current)
            <span class="absolute -top-12 left-1/2 z-10 -translate-x-1/2">
                <span class="float bg-card border-signal/60 text-signal font-rune relative block rounded-xl border-2 px-3 py-1.5 text-sm font-bold tracking-widest whitespace-nowrap uppercase">
                    Başla
                    <span aria-hidden="true" class="bg-card border-signal/60 absolute -bottom-[7px] left-1/2 size-3 -translate-x-1/2 rotate-45 border-r-2 border-b-2"></span>
                </span>
            </span>

            <x-mascot
                :color="$mascotColor"
                mood="wave"
                @class([
                    'pointer-events-none absolute top-0 size-20 sm:size-24',
                    'right-full mr-4 sm:mr-8' => $offset >= 0,
                    'left-full ml-4 sm:ml-8' => $offset < 0,
                ])
            />
        @endif

        @if ($kind === MissionKind::Challenge)
            <svg aria-hidden="true" viewBox="0 0 40 18" @class(['mb-1 h-5 w-11', 'text-signal' => ! $isLocked, 'text-line' => $isLocked])>
                <path d="M2 16 4 4l8 7 8-9 8 9 8-7 2 12Z" fill="currentColor" />
            </svg>
        @endif

        <span
            @class(['shield-node relative', 'node-glow' => $state === MissionState::Current])
            style="--node-deep: {{ $deep }}"
        >
            @if ($isLocked)
                <span
                    role="img"
                    aria-label="{{ $label }}"
                    @class([
                        'text-muted grid place-items-center',
                        'shield-face' => $kind === MissionKind::Lesson || $kind === MissionKind::Simulation,
                        'shield-face-large' => $kind === MissionKind::Challenge,
                        'size-16 rounded-full' => $kind === MissionKind::Interlude,
                    ])
                    style="background: {{ $face }}"
                >
                    <x-icons.lock class="size-8" />
                </span>
            @else
                <a
                    href="{{ route('missions.show', $mission) }}"
                    aria-label="{{ $label }}"
                    @class([
                        'focus-visible:outline-ink relative grid place-items-center text-[#0c0b0f] transition-[filter] hover:brightness-110 focus-visible:outline-4 focus-visible:outline-offset-4',
                        'shield-face' => $kind === MissionKind::Lesson || $kind === MissionKind::Simulation,
                        'shield-face-large text-[#fff1f1]' => $kind === MissionKind::Challenge,
                        'size-16 rounded-full ring-4 ring-black/25 ring-inset' => $kind === MissionKind::Interlude,
                    ])
                    style="background: radial-gradient(circle at 50% 30%, color-mix(in oklab, {{ $face }} 75%, white), {{ $face }} 60%)"
                >
                    <x-dynamic-component :component="$mission->icon()" @class(['size-9' => $kind !== MissionKind::Interlude, 'size-7' => $kind === MissionKind::Interlude]) />
                </a>
            @endif

            @if ($state === MissionState::Completed)
                <span aria-hidden="true" class="bg-signal border-paper absolute -right-2 bottom-0 grid size-7 place-items-center rounded-full border-2 text-[#1d1408]">
                    <x-icons.check class="size-4" />
                </span>
            @endif
        </span>

        @unless ($kind === MissionKind::Lesson)
            <p @class([
                'rune-label mt-3 text-xs',
                'text-[#ff8a96]' => $kind === MissionKind::Challenge && ! $isLocked,
                'text-signal' => $kind === MissionKind::Interlude && ! $isLocked,
                'text-rune' => $kind === MissionKind::Simulation && ! $isLocked,
                'text-muted' => $isLocked,
            ])>{{ $kind->label() }}</p>
        @endunless

        <p @class(['max-w-[9.5rem] text-center leading-tight font-bold sm:max-w-[11rem]', 'mt-4' => $kind === MissionKind::Lesson, 'mt-1' => $kind !== MissionKind::Lesson, 'text-muted' => $isLocked])>{{ $mission->title() }}</p>
        <p class="text-muted mt-1 flex items-center gap-1 text-sm">
            <x-icons.bolt class="text-signal size-3.5" /> {{ $mission->xp() }} XP · {{ $mission->estimatedMinutes() }} dk
        </p>
    </div>
</li>
