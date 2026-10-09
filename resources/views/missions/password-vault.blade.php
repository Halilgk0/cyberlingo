<x-layouts.mission :mission="$mission" :steps="['kasa' => 'Kasayı aç', 'doldur' => 'Otomatik doldur', 'sina' => 'Sına']">
    <x-slot:intro>
        Her hesapta ayrı ve uzun bir parola… Peki hepsini nasıl hatırlayacaksın? Hatırlamayacaksın: hepsini bir parola kasası saklar.
        Bu kısa ara bilgide kasanı açacak, kendine kırılmaz bir parola ürettirecek ve kasanın sahte siteleri senden önce nasıl yakaladığını göreceksin.
    </x-slot:intro>

    <x-mission.step id="kasa" number="1" title="Tek anahtar, yüz kilit">
        <div class="lesson">
            <p>
                <strong>Parola kasası</strong> (parola yöneticisi), bütün parolalarını şifreli bir kasada saklayan uygulamadır.
                Kasayı tek bir <strong>ana parola</strong> açar. Eski hazine sandıkları gibi: anahtar sende olmadıkça içindekiler kimsenin işine yaramaz.
            </p>
            <ul>
                <li><strong>Senin yerine hatırlar:</strong> Her site için ayrı, uzun ve rastgele parolalar saklar.</li>
                <li><strong>Senin yerine üretir:</strong> Tek tıkla tahmin edilemez parolalar oluşturur.</li>
                <li><strong>Seni korur:</strong> Parolayı yalnızca kaydedildiği sitede doldurur. Bunun neden önemli olduğunu ikinci adımda göreceksin.</li>
            </ul>
            <p>Aşağıdaki kasayı aç ve kendine yeni bir parola üret. Bu demoda ana parola: <strong class="font-mono">Kale-Kapisi-Gece-Acilir-9</strong></p>
        </div>

        <div
            data-vault
            data-master="Kale-Kapisi-Gece-Acilir-9"
            data-requirement="Kasayı aç ve yeni bir parola üret"
            class="bg-card border-line riveted mt-6 overflow-hidden rounded-[1.5rem] border-2"
        >
            <form data-vault-lock class="flex flex-col items-center gap-4 px-6 py-10 text-center">
                <span class="bg-paper border-signal/50 text-signal grid size-20 place-items-center rounded-full border-4 shadow-[0_0_30px_rgb(232_176_74/0.25)]">
                    <x-icons.vault class="size-10" />
                </span>
                <p class="font-display text-3xl font-extrabold">Kasa kilitli</p>
                <label for="vault-master" class="sr-only">Ana parola</label>
                <input id="vault-master" data-vault-master type="password" autocomplete="off" placeholder="Ana parolayı yaz" class="field max-w-sm text-center">
                <button type="submit" class="btn-primary">Kasayı aç</button>
                <p data-vault-error aria-live="polite" class="text-alert max-w-sm font-bold empty:hidden"></p>
            </form>

            <div data-vault-open class="p-5 sm:p-7" hidden>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <p data-vault-title tabindex="-1" class="font-display text-3xl font-extrabold focus:outline-none">Kasan açık</p>
                    <span class="text-safe rune-label text-xs">3 kayıt · şifreli</span>
                </div>

                <ul class="mt-4 flex flex-col gap-2">
                    @foreach ([
                        ['mavibank.com.tr', 'ayse.yilmaz', 'q7#Vt2m!Lx9@Rk4pW1zN'],
                        ['posta.example', 'ayse@posta.example', 'T9$wHe4!pQ2vZm8&Lc6r'],
                        ['okulportal.example', 'ayse.yilmaz', 'Bn5^Xy2*Kd8#Fs1@Wq7e'],
                    ] as [$site, $username, $password])
                        <li data-vault-entry class="bg-paper border-line flex flex-wrap items-center gap-x-4 gap-y-1 rounded-xl border px-4 py-3">
                            <span class="min-w-0 grow">
                                <span class="block font-bold">{{ $site }}</span>
                                <span class="text-muted block text-sm">{{ $username }}</span>
                            </span>
                            <span data-vault-secret="{{ $password }}" class="font-mono tracking-wider">••••••••••••</span>
                            <button type="button" data-vault-reveal class="text-signal text-sm font-bold underline-offset-4 hover:underline">Göster</button>
                        </li>
                    @endforeach
                </ul>

                <div class="border-line mt-6 border-t pt-5">
                    <button type="button" data-vault-generate class="btn-secondary">
                        <x-icons.key class="size-5" /> Yeni parola üret
                    </button>
                    <div data-vault-generated class="mt-4" hidden>
                        <p class="text-muted text-sm font-bold">Kasanın senin için ürettiği parola</p>
                        <p data-vault-generated-value class="text-rune mt-1 font-mono text-xl font-bold break-all"></p>
                        <p data-vault-generated-note class="text-muted mt-2 text-sm leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>

        <x-callout title="Ana parolan bir kez unutulursa" class="mt-8">
            İyi kasalar ana parolanı kendileri de bilmez; kasan senin cihazında, senin anahtarınla açılır. Bu güvenlidir ama ana parolanı
            unutursan kasayı kimse açamaz. Ana parolan için uzun bir parola cümlesi seç, kasada iki adımlı doğrulamayı aç ve kurtarma kodunu kâğıda yazıp sakla.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="doldur" number="2" title="Kasa sahte siteyi tanır">
        <div class="lesson">
            <p>
                Ayşe’ye iki bağlantı geldi; ikisi de Mavi Bank’ın giriş sayfası gibi görünüyor. Her birinde “Kasadan doldur”a bas ve kasanın ne yaptığına bak.
            </p>
        </div>

        <div data-autofill data-requirement="Otomatik doldurmayı iki sitede dene" class="mt-6 grid gap-4 md:grid-cols-2">
            @foreach ([['mavibank.com.tr', 'real'], ['mavibenk.com.tr', 'fake']] as [$domain, $kind])
                <section data-autofill-site="{{ $domain }}" aria-label="{{ $domain }} giriş sayfası" class="overflow-hidden rounded-[1.25rem] border-2 border-[#d6dbe4] bg-white text-[#1a2030]">
                    <p class="flex items-center gap-2 border-b border-[#e3e7ee] bg-[#f3f5f9] px-4 py-2.5 font-mono text-sm">
                        <x-icons.lock class="size-3.5 text-[#5b6578]" /> https://{{ $domain }}/giris
                    </p>
                    <div class="flex flex-col gap-3 p-5">
                        <p class="text-lg font-extrabold text-[#1f5fbf]">Mavi Bank · İnternet Şubesi</p>
                        <label class="text-sm font-bold">
                            Kullanıcı adı
                            <input data-autofill-username readonly class="mt-1 block w-full rounded-lg border-2 border-[#d6dbe4] px-3 py-2 font-normal">
                        </label>
                        <label class="text-sm font-bold">
                            Parola
                            <input data-autofill-password type="password" readonly autocomplete="off" class="mt-1 block w-full rounded-lg border-2 border-[#d6dbe4] px-3 py-2 font-normal">
                        </label>
                        <button type="button" data-autofill-button class="mt-1 flex items-center justify-center gap-2 rounded-lg bg-[#1a2030] px-4 py-2.5 font-bold text-white">
                            <x-icons.vault class="size-5" /> Kasadan doldur
                        </button>
                        <p data-autofill-result aria-live="polite" class="text-sm leading-relaxed font-bold data-[tone=correct]:text-[#13795b] data-[tone=wrong]:text-[#c8102e] empty:hidden"></p>
                    </div>
                </section>
            @endforeach
        </div>

        <x-callout tone="warning" title="Kasan doldurmuyorsa, elle yazma" class="mt-8" data-autofill-lesson hidden>
            Göz “mavibank” ile “mavibenk”i kolayca karıştırır; kasan karıştırmaz, çünkü sayfaya değil alan adına bakar.
            Kasa bir sitede parolanı doldurmuyorsa parolayı kopyalayıp elle yapıştırmak yerine dur ve adresi kontrol et. Büyük ihtimalle bir oltalama sayfasındasın.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Parola kasan, her zaman doldurduğu bir giriş sayfasında bu kez parolanı doldurmadı. Bu ne anlama gelebilir?">
                <x-quiz.option>Kasam bozuldu; parolamı elle kopyalayıp yapıştırırım.</x-quiz.option>
                <x-quiz.option correct>Sayfa sahte olabilir; adres çubuğundaki alan adını dikkatle kontrol ederim.</x-quiz.option>
                <x-quiz.option>Hiçbir anlamı yok, olur böyle şeyler.</x-quiz.option>

                <x-slot:explanation>
                    Kasa, parolayı yalnızca kaydedildiği alan adında doldurur. Doldurmaması çoğu zaman bir tehlike işaretidir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Ana parolan nasıl olmalı?">
                <x-quiz.option>Kısa ve kolay; nasılsa tek bir parola hatırlayacağım.</x-quiz.option>
                <x-quiz.option correct>Uzun bir parola cümlesi; başka hiçbir yerde kullanılmamış.</x-quiz.option>
                <x-quiz.option>Kasadaki en güçlü parolanın aynısı.</x-quiz.option>

                <x-slot:explanation>
                    Ana parola bütün kasanın anahtarıdır. Uzun, eşsiz ve sadece senin hatırlayacağın bir parola cümlesi seç.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Kasanı korumak için en iyi ek önlem hangisi?">
                <x-quiz.option>Ana parolayı bir arkadaşıma da söylemek.</x-quiz.option>
                <x-quiz.option>Kasayı hiç güncellememek.</x-quiz.option>
                <x-quiz.option correct>Kasada iki adımlı doğrulamayı açmak.</x-quiz.option>

                <x-slot:explanation>
                    Kasaya ikinci bir kilit takmak, ana parolan bir gün sızsa bile içeriğini korur.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
