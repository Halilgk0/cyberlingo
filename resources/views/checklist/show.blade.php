<x-layouts.app title="Kale kontrol listesi">
    @php
        $total = count(\App\Enums\ChecklistItem::cases());
        $checkedCount = count($checkedItems);
    @endphp

    <div class="mx-auto max-w-3xl py-8 sm:py-12">
        <header class="flex items-start gap-5">
            <div class="min-w-0 grow">
                <p class="rune-label text-rune">Kişisel güvenlik denetimi</p>
                <h1 class="font-display mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">Kale kontrol listesi</h1>
                <p class="text-muted mt-3 max-w-[56ch] leading-relaxed sm:text-lg">
                    Görevlerde öğrendiklerini gerçek hayatta da uyguladın mı? Yaptığın her şeyi işaretle; eksik kalanlar sıradaki işin olsun.
                    Liste yalnızca senin hesabında saklanır.
                </p>
            </div>
            <x-mascot :color="$learner->avatar_color" mood="think" class="hidden size-24 shrink-0 sm:block" />
        </header>

        <form data-checklist method="POST" action="{{ route('checklist.update') }}" class="mt-8 flex flex-col gap-10">
            @csrf
            @method('PUT')

            <div class="bg-card border-line riveted rounded-[1.25rem] border-2 p-5">
                <p class="flex items-baseline justify-between gap-3 font-bold">
                    <span>Kalenin hazırlığı</span>
                    <span class="text-rune"><span data-checklist-checked>{{ $checkedCount }}</span> / {{ $total }}</span>
                </p>
                <div aria-hidden="true" class="bg-line mt-3 h-3 overflow-hidden rounded-full">
                    <div data-checklist-meter class="bg-rune h-full rounded-full transition-[width] duration-500 ease-out" style="width: {{ $checkedCount / $total * 100 }}%"></div>
                </div>
                <p data-checklist-complete class="text-safe mt-3 font-bold" @if ($checkedCount < $total) hidden @endif>
                    Kalen tam teçhizatlı! “Kale denetçisi” rozeti artık senin.
                </p>
                <p data-checklist-status role="status" class="text-muted mt-2 text-sm empty:hidden"></p>
            </div>

            @foreach ($groups as $group => $items)
                <fieldset>
                    <legend class="font-display text-2xl leading-tight font-extrabold sm:text-3xl">{{ $group }}</legend>

                    <ul class="mt-4 flex flex-col gap-3">
                        @foreach ($items as $item)
                            @php($mission = $item->mission())
                            <li class="bg-card border-line has-checked:border-rune/60 has-checked:bg-rune/8 rounded-2xl border-2 p-4 transition-colors">
                                <label class="flex cursor-pointer items-start gap-4">
                                    <input type="checkbox" name="items[]" value="{{ $item->value }}" @checked(in_array($item, $checkedItems, true)) class="peer sr-only">
                                    <span aria-hidden="true" class="border-line peer-checked:border-rune peer-checked:bg-rune peer-focus-visible:outline-ink mt-0.5 grid size-7 shrink-0 place-items-center rounded-lg border-2 text-transparent transition-colors peer-checked:text-[#06201c] peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2">
                                        <x-icons.check class="size-4" />
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block leading-snug font-bold">{{ $item->title() }}</span>
                                        <span class="text-muted mt-1 block text-sm leading-relaxed">{{ $item->reason() }}</span>
                                    </span>
                                </label>

                                <p class="mt-2 pl-11 text-sm">
                                    @if ($learner->canStart($mission))
                                        <a href="{{ route('missions.show', $mission) }}" class="text-signal font-bold hover:underline">
                                            Nasıl yapılır? Görev {{ $mission->number() }}: {{ $mission->title() }}
                                        </a>
                                    @else
                                        <span class="text-muted">Görev {{ $mission->number() }} açılınca öğreneceksin.</span>
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </fieldset>
            @endforeach

            <div>
                <button type="submit" data-checklist-save class="btn-primary">Kaydet</button>
            </div>
        </form>
    </div>
</x-layouts.app>
