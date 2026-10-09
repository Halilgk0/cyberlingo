{{--
    One exchange in a practice chat: the incoming `messages`, then the replies to pick from.
    A turn without replies ends the chat.
--}}
<div data-chat-turn hidden>
    <template data-chat-turn-messages>{{ $messages }}</template>

    @if ($slot->hasActualContent())
        <div role="group" aria-label="Ne yanıt verirsin?">
            <p data-chat-turn-prompt tabindex="-1" class="font-bold focus:outline-none">Ne yanıt verirsin?</p>
            <div class="mt-3 flex flex-col gap-2">
                {{ $slot }}
            </div>
        </div>
    @endif
</div>
