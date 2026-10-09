<x-layouts.app title="Haftalık sıralama">
    <section class="flex flex-col items-center gap-3 pt-10 text-center sm:pt-14">
        <span class="bg-signal grid size-20 place-items-center rounded-full text-[#0d121c] shadow-[0_6px_0_#d99a12]">
            <x-icons.trophy class="size-10" />
        </span>
        <h1 class="font-display mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">Haftalık sıralama</h1>
        <p class="text-muted max-w-[46ch] text-lg leading-relaxed">
            Son 7 günde kazanılan XP’ye göre. Her yeni görev ve her tekrar seni yukarı taşır.
        </p>
    </section>

    <div class="mx-auto mt-10 max-w-2xl">
        @if ($leaders->isEmpty())
            <div class="bg-card border-line flex flex-col items-center gap-4 rounded-[1.5rem] border-2 p-8 text-center sm:flex-row sm:text-left">
                <x-mascot mood="think" class="size-24 shrink-0" />
                <div>
                    <p class="font-display text-xl font-extrabold">Bu hafta henüz kimse XP kazanmadı.</p>
                    <p class="text-muted mt-1">Bir görev bitir, listenin başına sen geç!</p>
                    <a href="{{ route('missions.index') }}" class="btn-primary mt-4">Öğrenme yoluna git</a>
                </div>
            </div>
        @else
            <ol class="flex flex-col gap-2">
                @foreach ($leaders as $leader)
                    @php($isMe = $leader->is($me))
                    <li
                        data-reveal
                        @class([
                            'flex items-center gap-3 rounded-2xl border-2 p-3 sm:gap-4 sm:px-4',
                            'border-safe bg-safe/10' => $isMe,
                            'border-line bg-card' => ! $isMe,
                        ])
                    >
                        <span class="font-display w-9 shrink-0 text-center text-2xl font-extrabold">
                            {{ match ($loop->iteration) { 1 => '🥇', 2 => '🥈', 3 => '🥉', default => $loop->iteration } }}
                            <span class="sr-only">. sıra</span>
                        </span>
                        <x-mascot :color="$leader->avatar_color" class="size-11 shrink-0" />
                        <span class="min-w-0 grow truncate font-bold">
                            {{ $leader->name }}
                            @if ($isMe)
                                <span class="text-safe">(sen)</span>
                            @endif
                        </span>
                        <span class="text-signal flex shrink-0 items-center gap-1 font-extrabold">
                            <x-icons.bolt class="size-5" /> {{ (int) $leader->weekly_xp }} XP
                        </span>
                    </li>
                @endforeach
            </ol>

            @unless ($leaders->contains($me))
                <p class="bg-card border-line text-muted mt-4 rounded-2xl border-2 p-4 text-center font-bold">
                    Bu hafta henüz listede değilsin. Bir görev bitir, XP kazan ve sıralamaya gir!
                </p>
            @endunless
        @endif
    </div>
</x-layouts.app>
