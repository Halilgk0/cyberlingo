@props(['safe' => false])

{{-- A reply the learner can send in a practice chat. `feedback` explains why it is safe or risky. --}}
<div data-chat-reply="{{ $safe ? 'safe' : 'risky' }}">
    <button
        type="button"
        class="border-line not-aria-disabled:hover:border-ink focus-visible:outline-ink data-[state=wrong]:border-alert data-[state=wrong]:bg-alert/8 w-full rounded-xl border-2 px-4 py-3 text-left leading-snug transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 data-[state=wrong]:line-through aria-disabled:cursor-default"
    >
        {{ $slot }}
    </button>
    <template data-chat-reply-feedback>{{ $feedback }}</template>
</div>
