<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Mesajların, parolaların ve banka işlemlerin internette her gün şifrelenerek taşınıyor. Bu görevde şifrelemenin ne olduğunu
        2000 yıllık bir yöntemle deneyerek öğrenecek, gizli bir mesajı kıracak ve modern şifrelerin neden kırılamadığını göreceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Şifreleme nedir?">
        <div class="lesson">
            <p>
                <strong>Şifreleme</strong>, bir mesajı anahtarı olmayan herkes için anlamsız bir karmaşaya çevirmektir. Mesajı yalnızca doğru
                <strong>anahtara</strong> sahip olan kişi eski haline getirebilir; buna <strong>şifre çözme</strong> denir.
            </p>
        </div>

        <figure class="bg-card border-line mt-6 rounded-[1.25rem] border p-5 sm:p-7">
            <figcaption class="text-muted font-bold">Şifreleme ve çözme, anahtar: 3</figcaption>
            <div class="mt-4 flex flex-col items-stretch gap-2 sm:flex-row sm:items-center">
                @foreach ([['Düz metin', 'MERHABA', false], ['Şifreli metin', 'ÖĞTJÇDÇ', true], ['Çözülmüş metin', 'MERHABA', false]] as [$label, $text, $isCipher])
                    @if (! $loop->first)
                        <p class="text-muted flex items-center justify-center gap-1 text-sm font-bold sm:flex-col">
                            <span>{{ $loop->index === 1 ? 'şifrele' : 'çöz' }}</span>
                            <span aria-hidden="true" class="text-xl leading-none"><span class="sm:hidden">↓</span><span class="hidden sm:inline">→</span></span>
                        </p>
                    @endif
                    <div @class(['grow rounded-xl border-2 px-4 py-3 text-center', 'border-alert/50 bg-alert/8' => $isCipher, 'border-line bg-paper' => ! $isCipher])>
                        <p class="text-muted text-sm font-bold">{{ $label }}</p>
                        <p class="mt-1 font-mono text-2xl font-bold tracking-wider">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </figure>

        <div class="lesson mt-8">
            <h3>2000 yıllık bir şifre: Sezar</h3>
            <p>
                Roma’da Jül Sezar’ın askeri mesajları için kullandığı anlatılan yöntem çok basittir: Her harf alfabede belli bir sayı kadar ileri kaydırılır.
                Bu sayı, şifrenin <strong>anahtarıdır</strong>. Anahtar 3 ise Türk alfabesinde A → Ç, B → D, M → Ö olur. Yukarıdaki MERHABA böyle şifrelendi.
                Mesajı alan kişi harfleri 3 geri kaydırarak çözer.
            </p>

            <h3>Sezar şifresi neden artık işe yaramaz?</h3>
            <p>
                Türk alfabesinde 29 harf var, yani denenebilecek sadece <strong>28 farklı anahtar</strong> mevcut. Saldırgan anahtarı bilmese bile hepsini
                tek tek dener ve okunabilir olanı bulur. Parola görevinden hatırladığın gibi buna <strong>kaba kuvvet saldırısı</strong> denir.
            </p>
            <p>Bir şifrenin gücü iki şeye bağlıdır: anahtarın gizli kalmasına ve olası anahtar sayısının akıl almaz derecede büyük olmasına.</p>
        </div>

        <ul class="mt-6 flex flex-col gap-3">
            @foreach ([
                ['Sezar şifresi', '28', 'Bir bilgisayar hepsini bir saniyeden çok daha kısa sürede dener.', 1],
                ['4 haneli PIN', '10.000', 'Bir bilgisayar için yine sadece saniyeler.', 2],
                ['AES-128 (modern şifreleme)', '340.282.366.920.938.463.463.374.607.431.768.211.456', 'Saniyede 10¹⁸ anahtar deneyebilen hayali bir süper bilgisayar bile hepsini denemek için evrenin yaşının yüzlerce katı kadar zamana ihtiyaç duyar.', 3],
            ] as [$cipherName, $keyCount, $verdict, $strength])
                <li class="bg-card border-line rounded-2xl border p-5">
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                        <p class="font-display text-xl font-extrabold tracking-tight">{{ $cipherName }}</p>
                        <p @class(['font-bold', 'text-alert' => $strength < 3, 'text-safe' => $strength === 3])>{{ $strength < 3 ? 'Kırılır' : 'Kırılamaz' }}</p>
                    </div>
                    <p class="text-muted mt-2 text-sm font-bold">Olası anahtar sayısı</p>
                    <p class="font-mono font-bold break-all">{{ $keyCount }}</p>
                    <p class="text-muted mt-2 leading-relaxed">{{ $verdict }}</p>
                </li>
            @endforeach
        </ul>

        <div class="lesson mt-8">
            <p>
                Modern şifreleme yöntemleri (AES gibi) herkese açıktır; nasıl çalıştıkları bir sır değildir. Güçlerini tamamen anahtardan alırlar.
                Bu yüzden güvenlikte altın kural şudur: <strong>Anahtarı koru.</strong> Parolan da çoğu zaman bu anahtarın kapısıdır.
            </p>

            <h3>Şifrelemeyi her gün kullanıyorsun</h3>
            <ul>
                <li><strong>HTTPS:</strong> Adres çubuğundaki kilit simgesi, siteyle arandaki bilgilerin şifreli gittiğini gösterir. Bağlantı görevinden hatırla: kilit, sitenin kime ait olduğunu söylemez.</li>
                <li><strong>Uçtan uca şifreleme:</strong> Bazı mesajlaşma uygulamalarında mesajı sadece sen ve karşındaki kişi okuyabilir; uygulamanın kendi sunucusu bile okuyamaz.</li>
                <li><strong>Cihaz şifrelemesi:</strong> Telefonun kilitliyken içindeki veriler şifreli tutulur. Telefon çalınsa bile ekran kilidi olmadan okunamaz. Ekran kilidi koymanın asıl nedeni de budur.</li>
            </ul>

            <h3>Uçtan uca şifrelemeyi aç, kapat</h3>
            <p>Ayşe, Mert’e bir mesaj gönderiyor. Mesaj önce uygulamanın sunucusuna, oradan Mert’e gidiyor. Anahtarı açıp kapatarak sunucunun ne gördüğüne bak.</p>
        </div>

        <figure data-e2e class="group/e2e bg-card border-line mt-6 rounded-[1.25rem] border p-5 sm:p-7">
            <x-switch data-e2e-toggle class="w-full sm:w-auto">Uçtan uca şifreleme</x-switch>

            <div class="mt-6 grid items-center gap-2 sm:grid-cols-[1fr_auto_1fr_auto_1fr]">
                <div class="border-line bg-paper rounded-xl border-2 p-4">
                    <p class="text-muted text-sm font-bold">Ayşe’nin telefonu</p>
                    <p class="mt-1 leading-snug">Yarın 15.00’te kütüphanede buluşalım</p>
                </div>
                <span aria-hidden="true" class="text-muted text-center text-xl"><span class="sm:hidden">↓</span><span class="hidden sm:inline">→</span></span>
                <div class="border-alert/50 bg-alert/8 group-data-[on]/e2e:border-safe/50 group-data-[on]/e2e:bg-safe/10 rounded-xl border-2 p-4 transition-colors">
                    <p class="text-muted text-sm font-bold">Uygulamanın sunucusu</p>
                    <p class="mt-1 leading-snug group-data-[on]/e2e:hidden">Yarın 15.00’te kütüphanede buluşalım</p>
                    <p class="mt-1 hidden font-mono leading-snug break-all group-data-[on]/e2e:block">x9Fq2Lm7Pz0Ra4Kw8Ys1Tb6Vn3Hd5Jc</p>
                </div>
                <span aria-hidden="true" class="text-muted text-center text-xl"><span class="sm:hidden">↓</span><span class="hidden sm:inline">→</span></span>
                <div class="border-line bg-paper rounded-xl border-2 p-4">
                    <p class="text-muted text-sm font-bold">Mert’in telefonu</p>
                    <p class="mt-1 leading-snug">Yarın 15.00’te kütüphanede buluşalım</p>
                </div>
            </div>

            <p aria-live="polite" class="mt-5 leading-relaxed">
                <span class="group-data-[on]/e2e:hidden">
                    <strong class="text-alert font-bold">Kapalı:</strong> Mesaj sadece yolda şifreli. Sunucuya ulaşınca açılıyor; sunucuyu ele geçiren bir saldırgan ya da meraklı bir çalışan mesajı okuyabilir.
                </span>
                <span class="hidden group-data-[on]/e2e:inline">
                    <strong class="text-safe font-bold">Açık:</strong> Mesaj Ayşe’nin telefonunda şifreleniyor ve sadece Mert’in telefonunda çözülüyor. Aradaki sunucu yalnızca anlamsız bir veri görüyor.
                </span>
            </p>
        </figure>

        <x-callout title="Şifreleme iyiler için de kötüler için de çalışır" class="mt-8">
            Fidye yazılımları da şifreleme kullanır: dosyalarını kendi anahtarlarıyla şifreler ve anahtar için para isterler.
            Anahtar onlarda olduğu sürece dosyaları kırmak neredeyse imkânsızdır. Buna karşı ne yapabileceğini son görevde öğreneceksin.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Sezar çarkı ve şifre kırma">
        <div class="lesson">
            <p>Önce kendi mesajını Sezar şifresiyle şifrele. Anahtarı değiştirdikçe her harfin neye dönüştüğünü izle.</p>
        </div>

        <div data-caesar-wheel data-requirement="Sezar çarkıyla bir mesaj şifrele" class="bg-card border-line mt-6 rounded-[1.25rem] border p-5 sm:p-7">
            <label for="caesar-message" class="block font-bold">Şifrelenecek mesaj</label>
            <input
                id="caesar-message"
                data-caesar-input
                type="text"
                autocomplete="off"
                spellcheck="false"
                placeholder="Adını ya da kısa bir mesaj yaz"
                class="border-line bg-paper focus:border-ink placeholder:text-muted/70 mt-2 w-full rounded-xl border-2 px-4 py-3 text-xl focus:outline-none"
            >

            <label for="caesar-shift" class="mt-6 flex items-baseline justify-between font-bold">
                Anahtar (kaydırma sayısı)
                <output data-caesar-shift-value for="caesar-shift" class="font-display text-2xl">3</output>
            </label>
            <input id="caesar-shift" data-caesar-shift type="range" min="1" max="28" value="3" class="accent-ink mt-2 w-full">

            <p class="text-muted mt-6 text-sm font-bold">Her harf şuna dönüşüyor:</p>
            <ol class="mt-2 grid grid-cols-[repeat(auto-fill,minmax(2.4rem,1fr))] gap-1.5 font-mono">
                @foreach (mb_str_split('ABCÇDEFGĞHIİJKLMNOÖPRSŞTUÜVYZ') as $letter)
                    <li data-caesar-letter="{{ $letter }}" class="border-line data-[active]:border-signal data-[active]:bg-signal/30 flex flex-col items-center rounded-lg border py-1 font-bold transition-colors">
                        <span>{{ $letter }}</span>
                        <span aria-hidden="true" class="bg-line my-1 h-0.5 w-4 rounded-full"></span>
                        <span data-caesar-mapped class="text-alert">{{ $letter }}</span>
                    </li>
                @endforeach
            </ol>

            <div class="border-line mt-6 grid gap-4 border-t pt-5 sm:grid-cols-2">
                <div>
                    <p class="text-muted text-sm font-bold">Düz metin</p>
                    <p data-caesar-plain class="mt-1 font-mono text-xl break-all">…</p>
                </div>
                <div>
                    <p class="text-muted text-sm font-bold">Şifreli metin</p>
                    <p data-caesar-cipher class="text-alert mt-1 font-mono text-xl font-bold break-all">…</p>
                </div>
            </div>
            <p data-caesar-status aria-live="polite" class="text-safe mt-5 font-bold empty:hidden"></p>
        </div>

        <h3 class="font-display mt-12 text-2xl leading-tight font-extrabold tracking-tight">Şimdi bir şifre kır</h3>
        <div class="lesson mt-3">
            <p>
                Bir casusun yakaladığı aşağıdaki mesaj Sezar şifresiyle şifrelenmiş, ama anahtarı bilmiyorsun. Kaydırıcıyla anahtarları tek tek dene.
                Mesaj okunur hale geldiğinde şifreyi kırmış olursun.
            </p>
        </div>

        <div
            data-caesar-crack
            data-plaintext="BULUŞMA YERİ KÜTÜPHANE, SAAT ÜÇTE"
            data-key="7"
            data-requirement="Gizli mesajın şifresini kır"
            class="bg-card border-line mt-6 rounded-[1.25rem] border p-5 sm:p-7"
        >
            <p class="text-muted text-sm font-bold">Yakalanan şifreli mesaj</p>
            <p data-crack-cipher class="text-alert mt-1 font-mono text-2xl font-bold break-words">…</p>

            <label for="crack-shift" class="mt-6 flex items-baseline justify-between font-bold">
                Denediğin anahtar
                <output data-crack-shift-value for="crack-shift" class="font-display text-2xl">1</output>
            </label>
            <input id="crack-shift" data-crack-shift type="range" min="1" max="28" value="1" class="accent-ink mt-2 w-full">

            <p class="text-muted mt-5 text-sm font-bold">Bu anahtarla çözülmüş hali</p>
            <p data-crack-attempt class="data-[cracked]:text-safe mt-1 font-mono text-2xl break-words data-[cracked]:font-bold">…</p>
            <p data-crack-status aria-live="polite" class="text-safe mt-4 font-bold empty:hidden"></p>

            <div data-crack-brute class="border-line mt-6 border-t pt-6" hidden>
                <p class="leading-relaxed">Sen anahtarları elle denedin. Bir bilgisayar aynı işi nasıl yapardı?</p>
                <button type="button" data-crack-brute-button class="btn-secondary mt-3">Bilgisayara kırdır</button>
                <ol data-crack-brute-list class="*:data-[match]:bg-safe/15 *:data-[match]:text-safe mt-4 flex flex-col gap-0.5 font-mono text-sm empty:hidden *:rounded-md *:px-2 *:py-0.5 *:data-[match]:font-bold"></ol>
                <p data-crack-brute-note class="mt-4 text-lg leading-relaxed" hidden></p>
            </div>
        </div>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Sezar şifresinde anahtar 1 ise “KEDİ” nasıl şifrelenir?">
                <x-quiz.option>JDÇI</x-quiz.option>
                <x-quiz.option correct>LFEJ</x-quiz.option>
                <x-quiz.option>LFEİ</x-quiz.option>

                <x-slot:explanation>
                    Her harf alfabede bir ileri kayar: K → L, E → F, D → E, İ → J. “JDÇI” ise bir geri kaydırılmış hali, yani çözme yönü.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Modern bir şifreyi güçlü yapan nedir?">
                <x-quiz.option>Şifreleme yönteminin gizli tutulması.</x-quiz.option>
                <x-quiz.option correct>Anahtarın gizli olması ve olası anahtar sayısının çok büyük olması.</x-quiz.option>
                <x-quiz.option>Mesajın kısa olması.</x-quiz.option>

                <x-slot:explanation>
                    AES gibi modern yöntemler herkese açıktır ve uzmanlar tarafından yıllarca incelenmiştir. Güçleri, tahmin edilemeyecek kadar çok olası anahtardan gelir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Uçtan uca şifrelenmiş bir mesajı kimler okuyabilir?">
                <x-quiz.option>Gönderen, alıcı ve uygulamanın sunucusu.</x-quiz.option>
                <x-quiz.option correct>Sadece gönderen ve alıcı.</x-quiz.option>
                <x-quiz.option>Aynı Wi-Fi ağındaki herkes.</x-quiz.option>

                <x-slot:explanation>
                    Uçtan uca şifrelemede mesaj gönderenin cihazında şifrelenir ve sadece alıcının cihazında çözülür. Aradaki sunucu ve ağ sadece anlamsız bir veri görür.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
