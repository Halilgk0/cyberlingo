@props(['name', 'icon', 'description'])

{{-- One app asking for permissions; its slot lists `x-permissions.item`s. --}}
<section data-permissions-app aria-label="{{ $name }}" hidden>
    <div class="mt-3 flex items-center gap-3">
        <span aria-hidden="true" class="bg-signal/40 grid size-12 shrink-0 place-items-center rounded-2xl text-2xl">{{ $icon }}</span>
        <div class="min-w-0">
            <p data-permissions-app-name tabindex="-1" class="font-sans text-xl leading-tight font-extrabold tracking-tight focus:outline-none">{{ $name }}</p>
            <p class="text-muted text-sm leading-snug">{{ $description }}</p>
        </div>
    </div>

    <p class="mt-5 text-sm font-bold">Bu uygulama şunlara erişmek istiyor:</p>
    <ul class="divide-line mt-1 flex flex-col divide-y">
        {{ $slot }}
    </ul>

    <button type="button" data-permissions-save class="btn-primary mt-5 w-full">Kaydet</button>
</section>
