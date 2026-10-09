<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'plan' => 'Planla', 'sina' => 'Sına']">
    <x-slot:intro>
        Fotoğrafların, ödevlerin, belgelerin… Bir gün bilgisayarın bozulabilir, telefonun çalınabilir ya da bir fidye yazılımı dosyalarını kilitleyebilir.
        Bunların hepsine karşı tek bir çare var: yedek. Bu görevde bir fidye yazılımı saldırısını güvenle yaşayacak, sonra kendi yedek planını kuracaksın.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Fidye yazılımı ve yedek">
        <div class="lesson">
            <h3>Fidye yazılımı nedir?</h3>
            <p>
                <strong>Fidye yazılımı</strong>, dosyalarını şifreleyip anahtarı vermek için para isteyen zararlı yazılımdır. Şifreleme görevinden hatırla:
                anahtar olmadan modern bir şifreyi kırmak neredeyse imkânsızdır. Fidye yazılımları genellikle bir e-posta ekinden, korsan bir programdan
                ya da güncellenmemiş bir sistemdeki güvenlik açığından bulaşır.
            </p>

            <h3>Fidyeyi ödemeli miyim?</h3>
            <ul>
                <li><strong>Ödesen bile anahtarı alacağının garantisi yok.</strong> Saldırganlar sözlerini tutmak zorunda değil.</li>
                <li><strong>Ödeyenler yeniden hedef olur.</strong> Para ödediğin öğrenilirse tekrar saldırıya uğrama ihtimalin artar.</li>
                <li><strong>Her fidye bir sonraki saldırıyı finanse eder.</strong> Ödenen para, saldırganların yeni araçlarına ve yeni kurbanlarına gider.</li>
            </ul>
            <p>
                Fidye ödememenin en kolay yolu buna ihtiyaç duymamaktır. Dosyalarının güncel bir yedeği varsa bilgisayarı temizler,
                dosyalarını yedekten geri yüklersin. Saldırgan elinde değersiz bir anahtarla kalır.
            </p>

            <h3>3-2-1 kuralı</h3>
            <p>Uzmanların yıllardır önerdiği basit bir kural, neredeyse her felakete karşı korur:</p>
        </div>

        <ol class="mt-5 grid gap-3 sm:grid-cols-3">
            @foreach ([
                ['3', 'kopya', 'Dosyalarının en az üç kopyası olsun: asıl dosyalar ve iki yedek.'],
                ['2', 'farklı ortam', 'Yedekler en az iki farklı türde ortamda dursun; örneğin harici disk ve bulut.'],
                ['1', 'kopya başka yerde', 'En az bir kopya evinin dışında olsun. Yangında ya da hırsızlıkta evdeki her şey birlikte gidebilir.'],
            ] as [$number, $rule, $explanation])
                <li class="bg-card border-line rounded-2xl border p-5">
                    <p class="font-display text-5xl leading-none font-extrabold">{{ $number }}</p>
                    <p class="font-display mt-1 text-xl font-extrabold tracking-tight">{{ $rule }}</p>
                    <p class="text-muted mt-2 leading-relaxed">{{ $explanation }}</p>
                </li>
            @endforeach
        </ol>

        <div class="lesson mt-8">
            <h3>Yedeği işe yarar kılan üç ayrıntı</h3>
            <ul>
                <li><strong>Harici diski yedek alırken tak, sonra çıkar.</strong> Fidye yazılımı bilgisayara takılı diskleri de şifreler.</li>
                <li><strong>Eşitleme yedek değildir.</strong> Sadece eşitleme yapan bir bulut klasörü, silinen ya da şifrelenen dosyayı buluta da aynen taşır. Eski sürümleri saklayan bir yedekleme hizmeti seç.</li>
                <li><strong>Geri yüklemeyi dene.</strong> Arada bir yedekten bir dosyayı geri getirip açılıyor mu bak. Hiç denenmemiş bir yedeğin işe yarayacağından emin olamazsın.</li>
            </ul>
        </div>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Fidye yazılımı simülasyonu">
        <div class="lesson">
            <p>
                Aşağıda bir bilgisayarın Belgeler klasörü var. Az önce bir e-posta geldi. Ekini aç ve neler olduğunu izle, sonra dosyalarını kurtarmanın yolunu bul.
            </p>
            <p class="text-muted text-base">Bu bir canlandırma: gerçek bir zararlı yazılım yok ve hiçbir dosyan etkilenmez.</p>
        </div>

        <div data-ransomware data-requirement="Fidye yazılımı saldırısından kurtul" class="mt-6 flex flex-col gap-4">
            <div class="bg-card border-line overflow-hidden rounded-[1.25rem] border">
                <div class="border-line bg-paper/60 flex items-center gap-3 border-b px-5 py-3">
                    <span aria-hidden="true" class="flex gap-1.5">
                        <span class="bg-line size-3 rounded-full"></span>
                        <span class="bg-line size-3 rounded-full"></span>
                        <span class="bg-line size-3 rounded-full"></span>
                    </span>
                    <p class="font-bold">Belgeler</p>
                </div>

                <ul class="grid grid-cols-2 gap-3 p-5 sm:grid-cols-3 sm:p-6">
                    @foreach ([['Ödev-Tarih.docx', '📄'], ['Tatil fotoğrafları', '🖼️'], ['Bütçe.xlsx', '📊'], ['Mezuniyet.mp4', '🎬'], ['Özgeçmiş.pdf', '📕'], ['Notlar.txt', '📝']] as [$fileName, $fileIcon])
                        <li data-file data-file-icon="{{ $fileIcon }}" data-file-name="{{ $fileName }}" class="border-line data-[locked]:border-alert/60 data-[locked]:bg-alert/8 flex min-w-0 items-center gap-3 rounded-xl border-2 p-3 transition-colors">
                            <span data-file-icon-display aria-hidden="true" class="text-2xl">{{ $fileIcon }}</span>
                            <span data-file-label class="min-w-0 text-sm font-bold break-all">{{ $fileName }}</span>
                        </li>
                    @endforeach
                </ul>

                <div data-ransom-note class="mx-5 mb-5 rounded-xl bg-[#7a0f1f] p-5 font-mono text-[#ffe8eb] sm:mx-6 sm:mb-6" hidden>
                    <p class="text-lg font-bold">TÜM DOSYALARINIZ ŞİFRELENDİ!</p>
                    <p class="mt-2 text-sm leading-relaxed">
                        Belgeleriniz, fotoğraflarınız ve videolarınız artık bizim anahtarımızla kilitli. Anahtarı almak için 72 saat içinde
                        500 dolar değerinde kripto para ödeyin. Süre dolarsa anahtar silinecek ve dosyalarınız sonsuza dek kaybolacak.
                    </p>
                </div>

                <div data-ransom-email class="border-line bg-paper/60 flex flex-wrap items-center gap-x-4 gap-y-3 border-t px-5 py-4 sm:px-6">
                    <p class="min-w-0 grow leading-snug">
                        <span class="text-muted block text-sm">Yeni e-posta · fatura@hizli-odeme.top</span>
                        <span class="font-bold">“Ödenmemiş faturanız var”</span> · Ek: <span class="font-mono">fatura.pdf.exe</span>
                    </p>
                    <button type="button" data-ransom-open class="btn-primary">Eki aç</button>
                </div>
            </div>

            <div data-ransom-choices role="group" aria-labelledby="ransom-choices-heading" hidden>
                <p id="ransom-choices-heading" data-ransom-choices-heading tabindex="-1" class="font-display text-2xl font-extrabold tracking-tight focus:outline-none">Ne yaparsın?</p>
                <div class="mt-3 grid gap-2 sm:grid-cols-3">
                    @foreach ([
                        'pay' => ['Fidyeyi öde', false],
                        'restart' => ['Bilgisayarı kapatıp aç', false],
                        'restore' => ['Bilgisayarı temizle, yedekten geri yükle', true],
                    ] as $choice => [$choiceLabel, $isRight])
                        <button
                            type="button"
                            data-ransom-choice="{{ $choice }}"
                            data-ransom-choice-right="{{ $isRight ? 'yes' : 'no' }}"
                            class="border-line not-aria-disabled:hover:border-ink focus-visible:outline-ink data-[state=correct]:border-safe data-[state=correct]:bg-safe/10 data-[state=wrong]:border-alert data-[state=wrong]:bg-alert/8 rounded-xl border-2 px-4 py-3 text-left leading-snug font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 aria-disabled:cursor-default"
                        >
                            {{ $choiceLabel }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div data-ransom-feedback aria-live="polite" class="data-[tone=correct]:border-safe data-[tone=correct]:bg-safe/10 data-[tone=wrong]:border-alert data-[tone=wrong]:bg-alert/8 rounded-xl border-l-4 px-5 py-4 leading-relaxed" hidden>
                <p data-ransom-feedback-title class="font-bold"></p>
                <div data-ransom-feedback-body class="mt-1"></div>
            </div>

            <template data-ransom-outcome="pay">
                Saldırganlar sözlerini tutmak zorunda değil. Şimdi hem paran hem dosyaların gitti; üstelik “ödeyen biri” olarak listelerine girdin. Başka bir yol dene.
            </template>
            <template data-ransom-outcome="restart">
                Yeniden başlatmak şifrelemeyi geri almaz. Dosyalar ancak anahtarla ya da bir yedekten kurtarılabilir. Başka bir yol dene.
            </template>
            <template data-ransom-outcome="restore">
                Bilgisayarı temizleyip geçen hafta aldığın yedekten dosyalarını geri yükledin. Yedek diskini yedeği aldıktan sonra çıkarmıştın;
                takılı kalsaydı fidye yazılımı onu da şifreleyecekti. Şimdi bir sonraki adımda her felakete dayanan bir yedek planı kur.
            </template>
        </div>
    </x-mission.step>

    <x-mission.step id="plan" number="3" title="Yedek planını kur">
        <div class="lesson">
            <p>
                Fotoğraflarının kopyalarını nerelerde tutacağını seç. Sağdaki felaket testi, her seçiminde hangi felakete dayanabildiğini anında gösterir.
                Hedefin: <strong>dört felakete de dayanan</strong> ve <strong>3-2-1 kuralına uyan</strong> bir plan.
            </p>
        </div>

        <div data-backup-planner data-requirement="Her felakete dayanan bir yedek planı kur" class="mt-6 grid items-start gap-6 lg:grid-cols-2">
            <fieldset class="flex flex-col gap-3">
                <legend class="font-bold">Fotoğraflarının kopyaları nerede dursun?</legend>

                <div class="border-line bg-paper mt-3 flex gap-3 rounded-2xl border-2 border-dashed p-4">
                    <span aria-hidden="true" class="mt-0.5 text-xl">💻</span>
                    <span>
                        <span class="block font-bold">Bilgisayarındaki asıl dosyalar</span>
                        <span class="text-muted mt-1 block text-sm leading-relaxed">Her zaman burada. Ama tek başına hiçbir felakete dayanamaz.</span>
                    </span>
                </div>

                @foreach ([
                    ['ikinci klasör', 'computer', false, 'deletion', 'Aynı bilgisayarda ikinci bir klasör', 'Kolay, ama bilgisayarla aynı yerde. Bilgisayar bozulursa ya da fidye yazılımı bulaşırsa bu kopya da gider.'],
                    ['hep takılı disk', 'external', false, 'broken deletion', 'Bilgisayara hep takılı harici disk', 'Bilgisayar bozulursa kurtarır. Ama hep takılı olduğu için fidye yazılımı onu da şifreler.'],
                    ['çıkarılan disk', 'external', false, 'broken ransomware deletion', 'Yedekten sonra çıkarılan harici disk', 'Çekmecede durduğu için fidye yazılımına yakalanmaz. Ama evde durduğu için yangında ya da hırsızlıkta gidebilir.'],
                    ['bulut eşitleme', 'cloud', true, 'broken fire', 'Bulut klasörü (sadece eşitleme)', 'Evin dışında saklanır. Ama değişiklikleri hemen kopyalar: şifrelenen ya da silinen dosya buluta da öyle gider.'],
                    ['bulut yedekleme', 'cloud', true, 'broken ransomware fire deletion', 'Bulut yedekleme (eski sürümleri saklar)', 'Evin dışında saklanır ve dosyaların eski sürümlerini tutar; şifrelenmeden önceki hale dönebilirsin.'],
                ] as [$shortName, $medium, $isOffsite, $survives, $optionTitle, $optionDescription])
                    <label class="has-checked:border-ink has-checked:bg-card border-line focus-within:outline-ink flex cursor-pointer gap-3 rounded-2xl border-2 p-4 transition-colors focus-within:outline-2 focus-within:outline-offset-2">
                        <input
                            type="checkbox"
                            data-backup-option
                            data-short-name="{{ $shortName }}"
                            data-medium="{{ $medium }}"
                            data-offsite="{{ $isOffsite ? 'yes' : 'no' }}"
                            data-survives="{{ $survives }}"
                            class="accent-ink mt-1 size-5 shrink-0 focus:outline-none"
                        >
                        <span>
                            <span class="block font-bold">{{ $optionTitle }}</span>
                            <span class="text-muted mt-1 block text-sm leading-relaxed">{{ $optionDescription }}</span>
                        </span>
                    </label>
                @endforeach
            </fieldset>

            <div class="flex flex-col gap-4 lg:sticky lg:top-6">
                <section aria-labelledby="disaster-test-heading" class="bg-card border-line rounded-[1.25rem] border p-5">
                    <h3 id="disaster-test-heading" class="font-display text-xl font-extrabold tracking-tight">Felaket testi</h3>
                    <ul class="mt-3 flex flex-col gap-3">
                        @foreach ([
                            'broken' => 'Bilgisayarın bozuldu',
                            'ransomware' => 'Fidye yazılımı bulaştı',
                            'fire' => 'Evde yangın çıktı ya da hırsız girdi',
                            'deletion' => 'Klasörü yanlışlıkla sildin',
                        ] as $disaster => $disasterLabel)
                            <li data-disaster="{{ $disaster }}" class="group/disaster flex items-start gap-3">
                                <span aria-hidden="true" class="bg-alert group-data-[survived]/disaster:bg-safe text-card grid size-7 shrink-0 place-items-center rounded-full font-bold transition-colors">
                                    <span class="group-data-[survived]/disaster:hidden">✗</span>
                                    <span class="hidden group-data-[survived]/disaster:inline">✓</span>
                                </span>
                                <span>
                                    <span class="block font-bold">{{ $disasterLabel }}</span>
                                    <span data-disaster-detail class="text-muted block text-sm">Bütün kopyaların gider.</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section aria-labelledby="backup-rule-heading" class="bg-card border-line rounded-[1.25rem] border p-5">
                    <h3 id="backup-rule-heading" class="font-display text-xl font-extrabold tracking-tight">3-2-1 kuralı</h3>
                    <ul class="mt-3 flex flex-col gap-3">
                        @foreach (['copies' => 'En az 3 kopya', 'media' => 'En az 2 farklı ortam', 'offsite' => 'En az 1 kopya evin dışında'] as $rule => $ruleLabel)
                            <li data-backup-rule="{{ $rule }}" class="group/rule flex items-start gap-3">
                                <span aria-hidden="true" class="bg-line group-data-[met]/rule:bg-safe text-card grid size-7 shrink-0 place-items-center rounded-full font-bold transition-colors">✓</span>
                                <span>
                                    <span class="block font-bold">{{ $ruleLabel }}</span>
                                    <span data-backup-rule-detail class="text-muted block text-sm"></span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <p data-backup-status aria-live="polite" class="data-[tone=correct]:border-safe data-[tone=correct]:bg-safe/10 border-signal bg-signal/15 rounded-xl border-l-4 px-5 py-4 leading-relaxed font-bold empty:hidden"></p>
            </div>
        </div>
    </x-mission.step>

    <x-mission.step id="sina" number="4" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="3-2-1 kuralındaki “1” ne anlama gelir?">
                <x-quiz.option>Yedek her gün bir kez alınmalı.</x-quiz.option>
                <x-quiz.option correct>En az bir kopya evinin dışında olmalı.</x-quiz.option>
                <x-quiz.option>Tek bir yedek yeterlidir.</x-quiz.option>

                <x-slot:explanation>
                    Yangın, sel ya da hırsızlık evdeki bütün kopyaları aynı anda götürebilir. Bulut yedeği ya da başka bir evde duran bir disk bu yüzden önemlidir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Harici diskine yedek aldın. İşin bitince ne yapmalısın?">
                <x-quiz.option>Bir dahaki sefere uğraşmamak için takılı bırakırım.</x-quiz.option>
                <x-quiz.option correct>Çıkarıp ayrı bir yerde saklarım, çünkü fidye yazılımı takılı diskleri de şifreleyebilir.</x-quiz.option>
                <x-quiz.option>Diskteki eski yedekleri silerim.</x-quiz.option>

                <x-slot:explanation>
                    Bilgisayara bağlı her disk, bilgisayara bulaşan bir fidye yazılımının da erişebileceği bir yerdir. Bağlantıyı kesmek yedeği korur.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Dosyaların fidye yazılımıyla şifrelendi ve güncel bir yedeğin var. Ne yapmalısın?">
                <x-quiz.option>Fidyeyi öderim; daha hızlı olur.</x-quiz.option>
                <x-quiz.option>Saldırganlarla pazarlık ederim.</x-quiz.option>
                <x-quiz.option correct>Fidyeyi ödemeden bilgisayarı temizler, dosyaları yedekten geri yüklerim.</x-quiz.option>

                <x-slot:explanation>
                    Güncel bir yedek, fidye yazılımını bir felaketten can sıkıcı bir güne çevirir. Geri yüklemeden önce bilgisayarı mutlaka temizle
                    ya da sıfırla; yoksa yedeğin de şifrelenebilir. Bir kuruma bağlıysan bilgi işlem ekibine haber ver.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
