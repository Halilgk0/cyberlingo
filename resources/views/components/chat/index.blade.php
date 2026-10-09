@props(['contact', 'detail', 'avatar' => null, 'requirement'])

{{--
    A practice conversation. Each turn's messages arrive in the thread, then the learner
    picks a reply: a risky one is explained and crossed out, the safe one is sent.
--}}
<div data-chat data-requirement="{{ $requirement }}" {{ $attributes->merge(['class' => 'flex flex-col gap-4']) }}>
    <div class="bg-card border-line overflow-hidden rounded-[1.25rem] border">
        <div class="border-line flex items-center gap-3 border-b px-5 py-3.5">
            <span aria-hidden="true" class="bg-line font-display grid size-10 shrink-0 place-items-center rounded-full text-lg font-extrabold">{{ $avatar ?? mb_substr($contact, 0, 1) }}</span>
            <div class="min-w-0">
                <p class="font-bold">{{ $contact }}</p>
                <p class="text-muted text-sm">{{ $detail }}</p>
            </div>
        </div>

        <div data-chat-log role="log" aria-label="{{ $contact }} ile sohbet" class="bg-paper/60 flex flex-col gap-2 px-4 py-5 sm:px-5"></div>
    </div>

    {{ $slot }}

    <div data-chat-coach aria-live="polite" class="data-[tone=correct]:border-safe data-[tone=correct]:bg-safe/10 data-[tone=wrong]:border-alert data-[tone=wrong]:bg-alert/8 rounded-xl border-l-4 px-5 py-4 leading-relaxed" hidden>
        <p data-chat-coach-title class="font-bold"></p>
        <div data-chat-coach-body class="mt-1"></div>
    </div>

    <button type="button" data-chat-continue class="btn-primary self-start" hidden>Sohbete devam et</button>

    <div data-chat-outcome tabindex="-1" class="bg-card border-line rounded-[1.25rem] border p-6 focus:outline-none sm:p-7" hidden>
        <p class="font-display text-2xl font-extrabold tracking-tight">Sohbet bitti</p>
        <div class="mt-2 max-w-[60ch] text-lg leading-relaxed">{{ $outcome }}</div>
    </div>

    <template data-chat-sent>
        <p class="bg-ink text-paper max-w-[85%] self-end rounded-2xl rounded-br-md px-4 py-2.5 leading-snug"></p>
    </template>
</div>
