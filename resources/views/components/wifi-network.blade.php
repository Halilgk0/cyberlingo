@props(['name', 'signal', 'secured' => false, 'real' => false])

{{--
    One network in the phone's Wi-Fi list. `signal` is 1–4 bars; `real` marks the network
    the learner should join. The slot explains why joining it is safe or risky.
--}}
<li data-network="{{ $real ? 'real' : 'fake' }}">
    <button
        type="button"
        class="not-aria-disabled:hover:bg-paper focus-visible:outline-ink data-[state=correct]:bg-safe/12 data-[state=wrong]:bg-alert/8 flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left transition-colors focus-visible:outline-2 aria-disabled:cursor-default"
    >
        <span aria-hidden="true" class="flex h-4 shrink-0 items-end gap-0.5">
            @foreach (range(1, 4) as $bar)
                <span @class(['w-1 rounded-sm', 'bg-ink' => $bar <= $signal, 'bg-line' => $bar > $signal]) style="height: {{ $bar * 25 }}%"></span>
            @endforeach
        </span>
        <span class="min-w-0 grow">
            <span class="block font-bold break-all">{{ $name }}</span>
            <span class="text-muted block text-sm">{{ $secured ? 'Şifreli' : 'Açık ağ, şifre yok' }} · Sinyal {{ $signal }}/4</span>
        </span>
        @if ($secured)
            <x-icons.lock class="text-muted size-4 shrink-0" />
        @endif
    </button>
    <template data-network-feedback>{{ $slot }}</template>
</li>
