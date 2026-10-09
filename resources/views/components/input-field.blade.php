@props(['name', 'label', 'type' => 'text', 'hint' => null, 'bag' => 'default'])

@php
    $id = $bag === 'default' ? $name : "{$bag}-{$name}";
    $error = $errors->getBag($bag)->first($name);
    $isPassword = $type === 'password';
    $describedBy = $error ? "{$id}-error" : ($hint ? "{$id}-hint" : null);
@endphp

{{--
    A labelled form input with an optional hint and its validation error. Passwords are never
    refilled; they get a show/hide button and, with a `minlength`, a live length count. Both
    appear only once the script runs.
--}}
<div>
    <label for="{{ $id }}" class="font-bold">{{ $label }}</label>
    <div @class(['relative mt-2' => $isPassword])>
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @if (! $isPassword) value="{{ old($name, $attributes->get('value')) }}" @endif
            @if ($error) aria-invalid="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->except('value')->class(['field', 'mt-2' => ! $isPassword, 'pr-24' => $isPassword, 'border-alert' => $error]) }}
        >
        @if ($isPassword)
            <button
                type="button"
                data-password-toggle
                aria-controls="{{ $id }}"
                aria-pressed="false"
                class="text-muted hover:text-ink focus-visible:outline-ink absolute inset-y-1 right-1 flex items-center gap-1.5 rounded-lg px-3 text-sm font-bold focus-visible:outline-2"
                hidden
            >
                <x-icons.eye class="size-5" />
                <span data-password-toggle-label>Göster</span>
            </button>
        @endif
    </div>
    @if ($hint && ! $error)
        <p id="{{ $id }}-hint" class="text-muted mt-1.5 text-sm leading-relaxed">{{ $hint }}</p>
    @endif
    @if ($isPassword && $attributes->has('minlength'))
        <p data-password-length class="text-muted data-[enough]:text-safe mt-1.5 text-sm font-bold" hidden></p>
    @endif
    @if ($error)
        <p id="{{ $id }}-error" class="text-alert mt-1.5 font-bold">{{ $error }}</p>
    @endif
</div>
