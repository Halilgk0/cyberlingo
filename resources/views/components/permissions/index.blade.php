@props(['requirement'])

{{--
    Apps shown one at a time on a phone. The learner switches on only the permissions
    each app really needs, saves, and gets a verdict on every permission.
--}}
<div data-permissions data-requirement="{{ $requirement }}" {{ $attributes->merge(['class' => 'grid items-start gap-6 lg:grid-cols-[21rem_1fr]']) }}>
    <x-phone label="Uygulama izinleri ekranı">
        <div class="px-5 pt-2 pb-6">
            <p data-permissions-progress class="text-muted text-sm font-bold">
                Uygulama <span data-permissions-position>1</span> / <span data-permissions-total></span>
            </p>

            {{ $slot }}

            <div data-permissions-done tabindex="-1" class="py-10 text-center focus:outline-none" hidden>
                <p class="font-display text-safe text-2xl font-extrabold tracking-tight">Hepsi tamam!</p>
                <p class="text-muted mt-2 leading-relaxed">Her uygulamaya yalnızca işini yapmak için gerçekten ihtiyaç duyduğu izinleri verdin.</p>
            </div>
        </div>
    </x-phone>

    <div class="flex flex-col gap-4">
        <div data-permissions-feedback aria-live="polite" class="data-[tone=correct]:border-safe data-[tone=correct]:bg-safe/10 data-[tone=wrong]:border-alert data-[tone=wrong]:bg-alert/8 border-signal bg-signal/15 rounded-xl border-l-4 px-5 py-4 leading-relaxed">
            <p data-permissions-feedback-title class="font-bold">Her izin için kendine sor: Bu uygulamanın işini yapması için buna gerçekten ihtiyacı var mı?</p>
            <p data-permissions-feedback-intro class="mt-1">İzinleri açıp kapattıktan sonra telefondaki “Kaydet” düğmesine bas. Her iznin doğru olup olmadığını burada göreceksin.</p>
            <ul data-permissions-results class="*:data-[tone=wrong]:border-alert *:data-[tone=correct]:border-safe mt-3 flex flex-col gap-3 empty:hidden *:border-l-4 *:pl-3"></ul>
        </div>

        <button type="button" data-permissions-next class="btn-primary self-start" hidden>Sonraki uygulama</button>
    </div>

    <template data-permissions-result>
        <li>
            <p data-permissions-result-title class="font-bold"></p>
            <div data-permissions-result-reason class="text-muted mt-0.5 leading-relaxed"></div>
        </li>
    </template>
</div>
