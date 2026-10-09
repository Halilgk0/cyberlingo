@props(['needed' => false])

{{-- One permission an app asks for. The slot is its name; `reason` explains whether the app needs it. --}}
<li data-permission="{{ $needed ? 'needed' : 'unneeded' }}" class="data-[result=wrong]:bg-alert/8 data-[result=correct]:bg-safe/10 -mx-2 rounded-lg px-2 py-2.5 transition-colors">
    <x-switch data-permission-toggle class="w-full">{{ $slot }}</x-switch>
    <template data-permission-reason>{{ $reason }}</template>
</li>
