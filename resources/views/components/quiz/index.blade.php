@props(['requirement' => 'Tüm soruları doğru yanıtla'])

{{-- A set of questions that must all be answered correctly to complete this step of the mission. --}}
<div data-quiz data-requirement="{{ $requirement }}" {{ $attributes->merge(['class' => 'flex flex-col gap-6']) }}>
    {{ $slot }}
</div>
