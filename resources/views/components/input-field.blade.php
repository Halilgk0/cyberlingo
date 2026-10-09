@props(['name', 'label', 'type' => 'text', 'hint' => null, 'bag' => 'default'])

@php
    $id = $bag === 'default' ? $name : "{$bag}-{$name}";
    $error = $errors->getBag($bag)->first($name);
@endphp

{{-- A labelled form input with an optional hint and its validation error. Passwords are never refilled. --}}
<div>
    <label for="{{ $id }}" class="font-bold">{{ $label }}</label>
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        @if ($type !== 'password') value="{{ old($name, $attributes->get('value')) }}" @endif
        @if ($error) aria-invalid="true" aria-describedby="{{ $id }}-error" @elseif ($hint) aria-describedby="{{ $id }}-hint" @endif
        {{ $attributes->except('value')->class(['field mt-2', 'border-alert' => $error]) }}
    >
    @if ($hint && ! $error)
        <p id="{{ $id }}-hint" class="text-muted mt-1.5 text-sm leading-relaxed">{{ $hint }}</p>
    @endif
    @if ($error)
        <p id="{{ $id }}-error" class="text-alert mt-1.5 font-bold">{{ $error }}</p>
    @endif
</div>
