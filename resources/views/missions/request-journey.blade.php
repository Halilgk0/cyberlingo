@php
    /* Plain strings, shown escaped; nothing here is sent anywhere. */
    $request = <<<'MESSAGE'
        GET /hesabim HTTP/1.1
        Host: mavibank.com.tr
        Cookie: oturum=8f2c4a…e91d
        User-Agent: Mozilla/5.0 (Android 14; Mobile)
        Accept-Language: tr-TR
        MESSAGE;
    $response = <<<'MESSAGE'
        HTTP/1.1 302 Found
        Location: /giris
        Set-Cookie: oturum=b71e…02af; Secure; HttpOnly; SameSite=Lax
        Strict-Transport-Security: max-age=31536000
        MESSAGE;
@endphp

<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'sirala' => 'Sırala', 'oku' => 'İsteği oku']">
    <x-slot:intro>
        Adres çubuğuna bir adres yazıp Enter’a bastığında, bir saniyeden kısa sürede küçük bir yolculuk başlar. Saldırganlar bu yolculuğun her
        durağını bilir; savunucular da her durağı korur. Bu görevde o yolculuğu adım adım izleyecek, sonra gerçek bir isteği bir savunucu gibi okuyacaksın.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Yolculuğun durakları">
        <ol class="grid gap-3 sm:grid-cols-2">
            @foreach ([
                ['IP adresi', 'İnternetteki her cihazın bir adresi vardır, örneğin 192.0.2.10. Bir sitenin sunucusu da böyle bir adreste oturur.'],
                ['DNS', 'İnternetin telefon rehberi. “mavibank.com.tr” gibi bir alan adını, bilgisayarların anladığı IP adresine çevirir.'],
                ['Port', 'Bir binadaki daire numarası gibidir. Aynı sunucuda birçok hizmet çalışır; HTTPS genellikle 443 numaralı kapıyı kullanır.'],
                ['TLS', 'Sunucu kimliğini bir sertifikayla kanıtlar, tarayıcı bunu doğrular ve aralarında şifreli bir tünel kurulur. HTTPS’teki “S” budur.'],
                ['HTTP isteği', 'Tarayıcının sunucudan istediği şey: hangi sayfa, hangi site ve seni tanıtan çerezler.'],
                ['HTTP yanıtı', 'Sunucunun cevabı: bir durum kodu (200 tamam, 302 yönlendir, 404 yok), başlıklar ve sayfanın kendisi.'],
            ] as [$stop, $description])
                <li class="bg-card border-line flex gap-4 rounded-2xl border-2 p-4 sm:p-5">
                    <span aria-hidden="true" class="bg-paper font-rune text-signal grid size-10 shrink-0 place-items-center rounded-xl text-sm font-bold">{{ $loop->iteration }}</span>
                    <span class="min-w-0">
                        <span class="font-display block text-xl leading-tight font-extrabold sm:text-2xl">{{ $stop }}</span>
                        <span class="text-muted mt-1 block leading-relaxed">{{ $description }}</span>
                    </span>
                </li>
            @endforeach
        </ol>

        <div class="lesson mt-10">
            <h3>Savunucu nereye bakar?</h3>
            <ul>
                <li><strong>Çerezler oturumun anahtarıdır.</strong> Giriş yaptıktan sonra site seni bir çerezle tanır. O çerezi ele geçiren, parolanı bilmeden hesabına girebilir. Bu yüzden çerezler <code>Secure</code> (yalnızca HTTPS’le gönder) ve <code>HttpOnly</code> (sayfadaki JavaScript okuyamasın) olarak işaretlenir.</li>
                <li><strong>HTTPS her durağı korur.</strong> İstek ve yanıt şifreli tünelden geçtiği için yoldaki biri içeriği okuyamaz. Ama kilit simgesi sitenin dürüst olduğunu değil, bağlantının şifreli olduğunu söyler.</li>
                <li><strong>Tarayıcıya kurallar söylenebilir.</strong> <code>Strict-Transport-Security</code> başlığı, tarayıcıya bu siteye bir süre yalnızca HTTPS ile bağlanmasını söyler; böylece biri bağlantıyı şifresiz sürüme düşüremez.</li>
            </ul>
        </div>

        <x-callout title="Kendin bak" class="mt-8">
            Bilgisayardaki tarayıcında bir sitede <strong class="font-bold">F12</strong> tuşuna basıp <strong class="font-bold">Ağ</strong> (Network) sekmesini aç ve sayfayı yenile.
            Sayfanın yaptığı bütün istekleri, durum kodlarını ve başlıkları görürsün. Bu araç tarayıcının kendisindedir ve yalnızca senin bilgisayarındaki trafiği gösterir.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="sirala" number="2" title="Yolculuğu sırala">
        <div class="lesson">
            <p>Adres çubuğuna <code>mavibank.com.tr</code> yazıp Enter’a bastın. Olanları sırayla seç; iki yanlış inanışa dikkat.</p>
        </div>

        <x-response-plan requirement="İsteğin yolculuğunu sırala" title="Yolculuk" class="mt-6">
            <x-response-plan.step stage="3">
                TLS el sıkışması: sunucu sertifikasını gösterir, tarayıcı doğrular ve şifreli bir tünel kurulur.

                <x-slot:why>
                    Sertifika, sunucunun gerçekten <code>mavibank.com.tr</code> olduğunu kanıtlar. Bundan sonra konuşulan her şey şifrelidir.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step trap>
                Tarayıcı, parolanı doğrulaması için DNS sunucusuna gönderir.

                <x-slot:why>
                    DNS yalnızca alan adını IP adresine çevirir. Parolan hiçbir zaman DNS’e gitmez; yalnızca şifreli tünelden, sitenin kendisine gider.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="1">
                Tarayıcı DNS’e sorar: “mavibank.com.tr hangi IP adresinde?”

                <x-slot:why>
                    Bilgisayarlar alan adlarını değil IP adreslerini anlar. Yolculuk her zaman bu çeviriyle başlar.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="5">
                Sunucu yanıt verir: bir durum kodu, başlıklar ve sayfanın HTML’i.

                <x-slot:why>
                    Yanıtın başlıkları da önemlidir: çerezlerin nasıl saklanacağını ve tarayıcının hangi kurallara uyacağını onlar söyler.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="2">
                Tarayıcı o IP adresinin 443 numaralı kapısına (portuna) bağlanır.

                <x-slot:why>
                    HTTPS hizmeti genellikle 443 numaralı porttan verilir. Bağlantı kurulmadan hiçbir şey gönderilemez.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step trap>
                Kilit simgesi göründüğü için tarayıcı sitenin dolandırıcı olmadığını onaylar.

                <x-slot:why>
                    Kilit yalnızca bağlantının şifreli olduğunu ve sertifikanın o alan adına verildiğini söyler. Sahte bir sitenin de geçerli bir sertifikası olabilir.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="6">
                Tarayıcı sayfayı çizer; resimler, CSS ve JavaScript dosyaları için yeni istekler atar.

                <x-slot:why>
                    Tek bir sayfa için çoğu zaman onlarca istek yapılır. Tarayıcının Ağ sekmesinde hepsini görebilirsin.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="4">
                Tarayıcı şifreli tünelden HTTP isteğini gönderir: hangi sayfa, hangi site ve çerezler.

                <x-slot:why>
                    İstek tünelin içinden gittiği için yoldaki biri hangi sayfayı istediğini ya da çerezlerini göremez.
                </x-slot:why>
            </x-response-plan.step>

            <x-slot:summary>
                DNS, bağlantı, TLS, istek, yanıt ve çizim. Bir sonraki görevde parolanın bu yolculuğun sonunda sunucuda nasıl saklandığına bakacağız.
            </x-slot:summary>
        </x-response-plan>
    </x-mission.step>

    <x-mission.step id="oku" number="3" title="Bir isteği ve yanıtı oku">
        <div class="lesson">
            <p>
                Aşağıda Mavi Bank’a giden gerçekçi bir istek ve gelen yanıt var. Savunucu gözüyle oku ve soruları yanıtla.
                Bu görevdeki banka ve değerler uydurmadır.
            </p>
        </div>

        <x-quiz requirement="İstek ve yanıtı oku" class="mt-6">
            <x-quiz.question prompt="Bu istekte, çalınırsa parola bilinmeden hesaba girilmesini sağlayabilecek parça hangisi?" :code="$request">
                <x-quiz.option>Host satırı.</x-quiz.option>
                <x-quiz.option correct>Cookie satırındaki oturum değeri.</x-quiz.option>
                <x-quiz.option>User-Agent satırı.</x-quiz.option>

                <x-slot:explanation>
                    Oturum çerezi, giriş yaptıktan sonra bankanın seni tanıdığı anahtardır. Bu yüzden asla paylaşılmaz ve yalnızca HTTPS ile gönderilir.
                    User-Agent ise yalnızca tarayıcını ve cihazını tanıtır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="İstekteki Host satırı ne işe yarar?" :code="$request">
                <x-quiz.option correct>İsteğin hangi siteye gittiğini söyler; aynı sunucuda birçok site olabilir.</x-quiz.option>
                <x-quiz.option>Bilgisayarının IP adresini bankaya bildirir.</x-quiz.option>
                <x-quiz.option>İsteğin şifreli olup olmadığını gösterir.</x-quiz.option>

                <x-slot:explanation>
                    Tek bir IP adresinde onlarca site çalışabilir. Host satırı, sunucunun isteği doğru siteye yönlendirmesini sağlar.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Yanıttaki 302 Found ne anlama geliyor?" :code="$response">
                <x-quiz.option>Sayfa bulunamadı.</x-quiz.option>
                <x-quiz.option>Sunucuda bir hata oluştu.</x-quiz.option>
                <x-quiz.option correct>Tarayıcıya Location satırındaki adrese gitmesini söyleyen bir yönlendirme.</x-quiz.option>

                <x-slot:explanation>
                    3 ile başlayan kodlar yönlendirmedir. Burada oturum geçersiz olduğu için banka seni giriş sayfasına gönderiyor.
                    404 “bulunamadı”, 500 ise “sunucu hatası” demektir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Çerezin sonundaki Secure ve HttpOnly ne işe yarar?" :code="$response">
                <x-quiz.option correct>Secure çerezin yalnızca HTTPS ile gitmesini, HttpOnly sayfadaki JavaScript’in onu okuyamamasını sağlar.</x-quiz.option>
                <x-quiz.option>Çerezi şifreleyip daha uzun saklar.</x-quiz.option>
                <x-quiz.option>Çerezin yalnızca bu bilgisayarda çalışmasını sağlar.</x-quiz.option>

                <x-slot:explanation>
                    HttpOnly, sayfaya sızmış kötü bir betiğin (XSS) çerezi çalmasını zorlaştırır; Secure ise çerezin şifresiz bir bağlantıda açık gitmesini önler.
                    CyberLingo’nun oturum çerezi de bu iki işaretle gönderilir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Strict-Transport-Security satırı tarayıcıya ne söylüyor?" :code="$response">
                <x-quiz.option>Sitenin virüs taramasından geçtiğini.</x-quiz.option>
                <x-quiz.option correct>Bir yıl boyunca bu siteye yalnızca HTTPS ile bağlanmasını.</x-quiz.option>
                <x-quiz.option>Parolaların bir yıl sonra değiştirilmesi gerektiğini.</x-quiz.option>

                <x-slot:explanation>
                    <code>max-age=31536000</code> saniye, yani 365 gün. Bu süre boyunca tarayıcı siteye şifresiz bağlanmayı hiç denemez;
                    böylece kafe Wi-Fi’ındaki biri bağlantıyı şifresiz sürüme düşüremez.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
