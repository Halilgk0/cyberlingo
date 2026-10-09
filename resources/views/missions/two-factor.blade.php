<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Parolan ne kadar güçlü olursa olsun, bir gün bir sızıntıda ortaya çıkabilir ya da bir oltalama sayfasına yazılabilir.
        İki adımlı doğrulama, parolan çalınsa bile hesabını korur. Bu görevde nasıl çalıştığını öğrenecek, sonra bir doğrulama
        uygulamasını adım adım kurup saldırganın nerede takıldığını göreceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Kapıya ikinci bir kilit">
        <div class="lesson">
            <p>Bir hesaba girerken kim olduğunu üç farklı şekilde kanıtlayabilirsin:</p>
        </div>

        <ul class="mt-6 grid gap-3 sm:grid-cols-3">
            @foreach ([
                ['Bildiğin bir şey', 'Parola, PIN', 'Kolayca kopyalanır: biri öğrenirse o da bilir.'],
                ['Sahip olduğun bir şey', 'Telefonun, güvenlik anahtarın', 'Çalmak için yanında olmak gerekir.'],
                ['Olduğun bir şey', 'Parmak izin, yüzün', 'Genellikle cihazının kilidini açmak için kullanılır.'],
            ] as [$factor, $examples, $note])
                <li class="bg-card border-line rounded-2xl border p-5">
                    <p class="font-display text-xl leading-tight font-extrabold tracking-tight">{{ $factor }}</p>
                    <p class="mt-1 font-bold">{{ $examples }}</p>
                    <p class="text-muted mt-2 leading-relaxed">{{ $note }}</p>
                </li>
            @endforeach
        </ul>

        <div class="lesson mt-8">
            <p>
                <strong>İki adımlı doğrulama</strong> (kısaca 2FA), girişte bunlardan ikisini birlikte ister: genellikle parolanı ve telefonunu.
                Saldırgan parolanı öğrense bile telefonun elinde olmadığı için içeri giremez. Parola görevinde öğrendiğin
                <em>kimlik bilgisi doldurma</em> saldırılarına karşı da en etkili korumadır.
            </p>

            <h3>Hangi yöntem ne kadar güçlü?</h3>
        </div>

        <ol class="mt-5 flex flex-col gap-3">
            @foreach ([
                [1, 'SMS ile gelen kod', 'İyi', 'Hiç yoktan çok daha iyi. Ama kodu bir dolandırıcıya okutabilirler ya da hattın sahte bir kimlikle başka bir SIM karta taşınabilir.'],
                [2, 'Doğrulama uygulaması', 'Daha iyi', 'Kod internet olmadan, doğrudan telefonunda üretilir ve 30 saniyede bir değişir. Yolda çalınamaz.'],
                [3, 'Güvenlik anahtarı ya da geçiş anahtarı (passkey)', 'En iyi', 'Sadece gerçek sitede çalışır. Sahte bir siteye kod yazdırılamadığı için oltalamaya karşı da korur.'],
            ] as [$strength, $method, $verdict, $explanation])
                <li class="bg-card border-line flex flex-col gap-3 rounded-2xl border p-5 sm:flex-row sm:items-start sm:gap-6">
                    <div class="flex shrink-0 items-center gap-3 sm:w-40 sm:flex-col sm:items-start">
                        <div class="grid w-24 grid-cols-3 gap-1" aria-hidden="true">
                            @foreach (range(1, 3) as $segment)
                                <span @class(['h-2 rounded-full', 'bg-safe' => $segment <= $strength, 'bg-line' => $segment > $strength])></span>
                            @endforeach
                        </div>
                        <span class="text-safe font-bold">{{ $verdict }}</span>
                    </div>
                    <div>
                        <p class="font-display text-xl leading-tight font-extrabold tracking-tight">{{ $method }}</p>
                        <p class="text-muted mt-1 leading-relaxed">{{ $explanation }}</p>
                    </div>
                </li>
            @endforeach
        </ol>

        <div class="lesson mt-8">
            <h3>Doğrulama uygulaması nasıl çalışır?</h3>
            <ol>
                <li>Kurulumda site sana bir <strong>QR kod</strong> gösterir. Bu kodun içinde sadece senin hesabına ait gizli bir anahtar vardır.</li>
                <li>Uygulama QR kodu tarar ve anahtarı telefonuna kaydeder. Artık site ve telefonun <strong>aynı gizli anahtarı</strong> biliyor.</li>
                <li>Her 30 saniyede bir, hem site hem telefonun bu anahtarı ve o anki saati kullanarak <strong>aynı 6 haneli kodu</strong> hesaplar.</li>
                <li>Girişte telefonundaki kodu yazarsın. Site, kendi hesapladığı kodla karşılaştırır. Kodlar tutuyorsa içeri girersin.</li>
            </ol>
            <p>Kod internet üzerinden gönderilmediği için yolda çalınamaz ve 30 saniye sonra işe yaramaz hale gelir.</p>

            <h3>Nasıl açılır?</h3>
            <p>
                Çoğu sitede ve uygulamada yol aşağı yukarı aynıdır: <strong>Ayarlar › Güvenlik › İki adımlı doğrulama</strong>.
                Önce e-posta hesabından başla; diğer hesaplarının parolalarını sıfırlamak için e-postan kullanıldığı için en değerli hesabın odur.
            </p>
        </div>

        <x-callout tone="warning" title="Yedek kodlarını sakla" class="mt-8">
            Kurulumun sonunda site sana birkaç yedek kod verir. Telefonunu kaybedersen hesabına bunlarla girersin.
            Onları kâğıda yazıp güvenli bir yerde sakla ya da parola yöneticine kaydet; sadece telefonunda tutma.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Doğrulama uygulamasını kur">
        <div class="lesson">
            <p>
                Solda bir e-posta sitesinin güvenlik ayarları, sağda telefonundaki doğrulama uygulaması var.
                Adımları izleyerek Ayşe’nin hesabında iki adımlı doğrulamayı aç.
            </p>
        </div>

        <div
            data-two-factor
            data-secret="JBSWY3DPEHPK3PXP"
            data-requirement="Doğrulama uygulamasını kur ve kodu doğrula"
            class="mt-6 grid items-start gap-6 lg:grid-cols-[1fr_21rem]"
        >
            <section aria-labelledby="two-factor-site-heading" class="bg-card border-line overflow-hidden rounded-[1.25rem] border">
                <p class="border-line bg-paper/60 text-muted border-b px-5 py-3 text-sm sm:px-6">
                    <span class="text-ink font-bold">posta.example</span> › Hesap › Güvenlik
                </p>

                <div class="p-5 sm:p-6">
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                        <h3 id="two-factor-site-heading" class="font-sans text-2xl font-extrabold tracking-tight">İki adımlı doğrulama</h3>
                        <p data-two-factor-state class="text-alert data-[on]:text-safe font-bold">Kapalı</p>
                    </div>

                    <div data-two-factor-step="scan" class="mt-5">
                        <p class="font-bold">1. Doğrulama uygulamanla bu QR kodu tara</p>
                        <div class="mt-3 flex flex-wrap items-center gap-5">
                            <x-fake-qr class="size-36 shrink-0 rounded-lg" />
                            <p class="text-muted max-w-[30ch] text-sm leading-relaxed">
                                QR kodu tarayamıyorsan bu kurulum anahtarını uygulamaya elle gir:
                                <span class="text-ink mt-1 block font-mono text-base font-bold">JBSW Y3DP EHPK 3PXP</span>
                            </p>
                        </div>
                        <p class="text-muted mt-4">Telefondaki <strong class="text-ink font-bold">QR kodu tara</strong> düğmesine bas.</p>
                    </div>

                    <form data-two-factor-step="verify" class="mt-6" hidden>
                        <label for="two-factor-code" class="font-bold">2. Uygulamadaki 6 haneli kodu yaz</label>
                        <div class="mt-3 flex flex-wrap gap-3">
                            <input
                                id="two-factor-code"
                                data-two-factor-input
                                inputmode="numeric"
                                autocomplete="off"
                                maxlength="7"
                                placeholder="123 456"
                                class="border-line bg-paper focus:border-ink placeholder:text-muted/60 w-44 rounded-xl border-2 px-4 py-2.5 font-mono text-xl tracking-widest focus:outline-none"
                            >
                            <button type="submit" class="btn-primary">Doğrula</button>
                        </div>
                        <p data-two-factor-error aria-live="polite" class="text-alert mt-2 font-bold empty:hidden"></p>
                    </form>

                    <div data-two-factor-step="done" class="mt-6" hidden>
                        <p data-two-factor-done tabindex="-1" class="font-display text-safe text-2xl font-extrabold tracking-tight focus:outline-none">İki adımlı doğrulama açıldı!</p>
                        <p class="mt-2 leading-relaxed">
                            Son bir şey: telefonunu kaybedersen hesabına girebilmen için yedek kodların. Her biri yalnızca bir kez kullanılabilir.
                        </p>
                        <ul class="bg-paper border-line mt-3 grid grid-cols-[repeat(auto-fill,minmax(6.5rem,1fr))] gap-x-6 gap-y-1 rounded-xl border p-4 font-mono font-bold whitespace-nowrap">
                            @foreach (['4821-7730', '1093-5562', '7710-2048', '3365-9014', '5527-0831', '9902-4417', '2264-6385', '8049-1176'] as $backupCode)
                                <li>{{ $backupCode }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>

            <x-phone label="Telefondaki doğrulama uygulaması">
                <div class="px-5 pt-2 pb-7">
                    <p class="font-sans text-lg font-extrabold tracking-tight">Doğrulayıcı</p>

                    <div data-authenticator-empty class="py-8 text-center">
                        <p class="text-muted">Henüz hesap eklenmedi.</p>
                        <button type="button" data-authenticator-scan class="btn-primary mt-4">QR kodu tara</button>
                    </div>

                    <div data-authenticator-account class="mt-4" hidden>
                        <div class="bg-paper border-line rounded-2xl border p-4">
                            <p class="text-muted text-sm font-bold">Örnek Posta · ayse@posta.example</p>
                            <p data-authenticator-code class="mt-1 font-mono text-4xl font-bold tracking-wider">--- ---</p>
                            <div class="mt-3 flex items-center gap-3">
                                <div class="bg-line h-1.5 grow overflow-hidden rounded-full" aria-hidden="true">
                                    <div data-authenticator-bar class="bg-safe h-full rounded-full transition-[width] duration-1000 ease-linear"></div>
                                </div>
                                <p class="text-muted text-sm tabular-nums"><span data-authenticator-seconds>30</span> sn</p>
                            </div>
                        </div>
                        <p data-totp-note class="text-muted mt-3 text-xs leading-relaxed">
                            Bu kod, gerçek doğrulama uygulamalarının kullandığı yöntemle (TOTP) gizli anahtardan ve şu anki saatten hesaplanıyor.
                        </p>
                    </div>
                </div>
            </x-phone>
        </div>

        <section data-attacker data-requirement="Saldırganın giriş denemesini izle" aria-labelledby="attacker-heading" class="mt-12" hidden>
            <h3 id="attacker-heading" class="font-display text-2xl leading-tight font-extrabold tracking-tight">Şimdi saldırganın yerine geç</h3>
            <p class="mt-2 max-w-[65ch] text-lg leading-relaxed">
                Diyelim ki Ayşe’nin parolası bir sızıntıda ortaya çıktı ve bir saldırganın eline geçti. Saldırgan, Ayşe’nin hesabına girmeyi deniyor.
                Parolayı biliyor ama telefonu yok. Onun yerine kodu tahmin etmeyi dene.
            </p>

            <div class="terminal mt-5">
                <p class="text-[#8193ad]">// saldırganın ekranı</p>
                <p class="mt-3">E-posta: ayse@posta.example</p>
                <p>Parola : •••••••••••• <span class="text-[#3dbe8b]">✓ doğru</span></p>
                <p class="mt-3 text-[#ffc24d]">Doğrulama kodu gerekiyor. Kod, Ayşe’nin telefonunda üretiliyor.</p>
                <ol data-attacker-log class="mt-3 flex flex-col gap-1 empty:hidden"></ol>
                <button type="button" data-attacker-guess class="mt-4 rounded-lg border-2 border-[#ff5a6e] px-4 py-2 font-bold text-[#ff5a6e] transition-colors hover:bg-[#ff5a6e]/15 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#ff5a6e]">
                    Kod tahmin et
                </button>
                <p data-attacker-status aria-live="polite" class="mt-4 font-bold text-[#ff5a6e] empty:hidden"></p>
            </div>

            <x-callout data-attacker-lesson title="Saldırgan parolayı bildiği halde giremedi" class="mt-6" hidden>
                Rastgele bir tahminin doğru çıkma ihtimali milyonda bir. Üstelik kod 30 saniyede bir değişiyor ve site birkaç hatalı denemeden sonra girişi kilitliyor.
                Ayşe de “hesabınıza giriş denendi” bildirimini görünce durumu anladı ve parolasını değiştirdi. İki adımlı doğrulama, sızıntıyı bir felakete dönüşmeden durdurdu.
            </x-callout>
        </section>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="İki adımlı doğrulaması açık bir hesabın parolası sızdı. Saldırgan neden yine de giremez?">
                <x-quiz.option>Sızan parolalar şifreli olduğu için okunamaz.</x-quiz.option>
                <x-quiz.option correct>Giriş için telefonumdaki kod da gerekiyor ve bu kod saldırganda yok.</x-quiz.option>
                <x-quiz.option>Site saldırganı otomatik olarak tanır ve engeller.</x-quiz.option>

                <x-slot:explanation>
                    İki adımlı doğrulama, parolayı tek başına işe yaramaz hale getirir. Yine de parolan sızdıysa onu hemen değiştir;
                    ikinci kilidin tek başına kalmasını isteme.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Hangisi en güçlü iki adımlı doğrulama yöntemidir?">
                <x-quiz.option>SMS ile gelen kod</x-quiz.option>
                <x-quiz.option>Doğrulama uygulamasındaki kod</x-quiz.option>
                <x-quiz.option correct>Güvenlik anahtarı ya da geçiş anahtarı (passkey)</x-quiz.option>

                <x-slot:explanation>
                    Güvenlik anahtarları ve geçiş anahtarları sadece gerçek sitenin adresiyle çalışır. Sahte bir oltalama sitesi
                    onları kullanamaz; bu yüzden kodu bir dolandırıcıya kaptırma riski de ortadan kalkar.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Telefonunu kaybettin ve doğrulama uygulaman o telefondaydı. Hesabına nasıl girersin?">
                <x-quiz.option>Giremem, hesabım sonsuza dek kilitlenir.</x-quiz.option>
                <x-quiz.option correct>Kurulumda güvenli bir yere kaydettiğim yedek kodlardan birini kullanırım.</x-quiz.option>
                <x-quiz.option>Sitenin destek ekibine parolamı e-postayla gönderirim.</x-quiz.option>

                <x-slot:explanation>
                    Yedek kodlar tam olarak bu durum için var. Girdikten sonra kayıp telefonu hesabından çıkar ve doğrulamayı yeni telefonunda yeniden kur.
                    Parolanı ise hiçbir zaman kimseye e-postayla gönderme.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
