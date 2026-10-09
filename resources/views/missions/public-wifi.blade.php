<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Kafeler, havalimanları, oteller… Ücretsiz Wi-Fi çok pratik, ama aynı ağa bağlanan herkesle aynı yolu paylaşırsın.
        Bu görevde o yolda neler olabileceğini bir saldırganın ekranından izleyecek ve sahte ağların arasından gerçeğini seçeceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Ortak ağın riskleri">
        <div class="lesson">
            <p>
                Wi-Fi ağı, cihazınla internet arasındaki bir yol gibidir. Evinde bu yolu sadece ailen kullanır. Halka açık bir ağda ise
                yanındaki masada oturan, tanımadığın biri de aynı yoldadır. Üç tehlike bu yüzden ortaya çıkar:
            </p>
            <ul>
                <li><strong>Dinleme:</strong> Şifrelenmemiş (http) bağlantılarda gönderdiğin her şey, aynı ağdaki biri tarafından ücretsiz programlarla okunabilir.</li>
                <li><strong>Kötü ikiz:</strong> Saldırgan, gerçek ağa benzeyen bir isimle (MaviKafe-Misafir-FREE gibi) kendi ağını açar. Ona bağlanırsan tüm trafiğin saldırganın cihazından geçer.</li>
                <li><strong>Sahte giriş sayfaları:</strong> Ağa bağlanınca açılan “giriş” sayfası e-posta parolanı ya da kart bilgini istiyorsa bu bir tuzaktır. Wi-Fi için bunlara gerek yoktur.</li>
            </ul>

            <h3>HTTPS seni nasıl korur?</h3>
            <p>
                HTTPS ile gönderdiğin bilgiler telefonundan çıkmadan şifrelenir ve sadece bağlandığın sitede çözülür. Aynı ağdaki biri
                <strong>hangi siteye</strong> bağlandığını görebilir ama <strong>ne yazdığını</strong> göremez. Bir sonraki adımda bunu kendi gözünle göreceksin.
                Günümüzde sitelerin çok büyük kısmı HTTPS kullanır; yine de parola ya da kart bilgisi yazmadan önce adres çubuğuna bakmak iyi bir alışkanlıktır.
            </p>

            <h3>Halka açık ağda dört alışkanlık</h3>
            <ol>
                <li><strong>Ağın adını doğrula.</strong> Tabeladan ya da personelden gerçek adı öğren; birebir aynı olmayan ağlara bağlanma.</li>
                <li><strong>Otomatik bağlanmayı kapat.</strong> İşin bitince ağı “unut”; telefonun aynı isimdeki sahte bir ağa kendiliğinden bağlanmasın.</li>
                <li><strong>Önemli işleri mobil veriyle yap.</strong> Bankacılık gibi işler için Wi-Fi’ı kapatıp mobil veriyi kullanmak en güvenlisidir.</li>
                <li><strong>HTTPS olmayan sitelere bilgi girme.</strong> Adres http ile başlıyorsa ya da tarayıcı “güvenli değil” diyorsa parola ve kart bilgisi yazma.</li>
            </ol>
        </div>

        <x-callout title="VPN ne işe yarar?" class="mt-8">
            VPN, cihazındaki tüm trafiği şifreli bir tünelle başka bir sunucuya taşır. Böylece aynı ağdaki biri hangi sitelere girdiğini bile göremez.
            Ama bu kez tüm trafiğin VPN şirketinden geçer. Güvenilir bir sağlayıcı seç; “ücretsiz ve sınırsız” vaat eden bilinmeyen uygulamalardan uzak dur.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Saldırganın gözünden">
        <div class="lesson">
            <p>
                Ayşe kafede, MaviKafe-Misafir ağında okulunun portalına giriş yapıyor. Aynı ağda bir saldırgan trafiği dinliyor.
                Önce <strong>http</strong> ile, sonra <strong>https</strong> ile “Giriş yap”a bas ve saldırganın ekranında neler göründüğünü karşılaştır.
            </p>
            <p class="text-muted text-base">Bu bir canlandırma; hiçbir bilgi bir yere gönderilmez.</p>
        </div>

        <div data-eavesdrop data-requirement="Girişi hem http hem https ile dene" class="mt-6 grid items-start gap-6 lg:grid-cols-[21rem_1fr]">
            <x-phone label="Ayşe’nin telefonu">
                <div class="px-5 pt-2 pb-7">
                    <div role="radiogroup" aria-label="Bağlantı türü" class="bg-paper border-line grid grid-cols-2 gap-1 rounded-xl border p-1">
                        <button type="button" role="radio" aria-checked="true" data-eavesdrop-mode="http" class="aria-checked:bg-alert aria-checked:text-card focus-visible:outline-ink rounded-lg py-2 font-bold transition-colors focus-visible:outline-2">http</button>
                        <button type="button" role="radio" aria-checked="false" data-eavesdrop-mode="https" class="aria-checked:bg-safe aria-checked:text-card focus-visible:outline-ink rounded-lg py-2 font-bold transition-colors focus-visible:outline-2">https</button>
                    </div>

                    <p class="bg-paper border-line mt-4 flex items-center gap-2 rounded-full border px-3 py-1.5 text-sm">
                        <span data-eavesdrop-badge class="text-alert data-[secure]:text-safe shrink-0 font-bold">Güvenli değil</span>
                        <span data-eavesdrop-url class="min-w-0 truncate font-mono">http://okulportal.example/giris</span>
                    </p>

                    <form data-eavesdrop-form class="mt-5 flex flex-col gap-3">
                        <p class="font-sans text-xl font-extrabold tracking-tight">Okul Portalı</p>
                        <label class="text-sm font-bold">
                            Kullanıcı adı
                            <input value="ayse.yilmaz" readonly class="border-line bg-paper mt-1 block w-full rounded-lg border-2 px-3 py-2 text-base font-normal">
                        </label>
                        <label class="text-sm font-bold">
                            Parola
                            <input type="password" value="Mavi-Kedi-Sabah-7" readonly autocomplete="off" class="border-line bg-paper mt-1 block w-full rounded-lg border-2 px-3 py-2 text-base font-normal">
                        </label>
                        <button type="submit" class="btn-primary mt-1">Giriş yap</button>
                    </form>
                </div>
            </x-phone>

            <section aria-labelledby="eavesdrop-heading">
                <h3 id="eavesdrop-heading" class="font-display text-2xl leading-tight font-extrabold tracking-tight">Aynı ağdaki saldırganın ekranı</h3>
                <div class="terminal mt-3">
                    <p class="text-[#8193ad]">// MaviKafe-Misafir ağındaki trafik dinleniyor…</p>
                    <ol
                        data-eavesdrop-log
                        aria-live="polite"
                        class="*:data-[tone=danger]:text-[#ff5a6e] *:data-[tone=safe]:text-[#3dbe8b] *:data-[tone=muted]:text-[#8193ad] mt-3 flex flex-col gap-1 break-words empty:hidden *:data-[tone=danger]:font-bold *:data-[tone=safe]:font-bold"
                    ></ol>
                </div>
                <p data-eavesdrop-explanation class="mt-4 text-lg leading-relaxed empty:hidden"></p>
                <ul class="mt-4 flex flex-wrap gap-2 text-sm font-bold">
                    <li data-eavesdrop-tried="http" class="border-line data-[done]:border-safe data-[done]:text-safe rounded-full border-2 px-3 py-1">http ile denendi</li>
                    <li data-eavesdrop-tried="https" class="border-line data-[done]:border-safe data-[done]:text-safe rounded-full border-2 px-3 py-1">https ile denendi</li>
                </ul>
            </section>
        </div>

        <h3 class="font-display mt-14 text-2xl leading-tight font-extrabold tracking-tight">Doğru ağı seç</h3>
        <div class="lesson mt-3">
            <p>Şimdi sıra sende. Mavi Kafe’ye geldin ve internete bağlanmak istiyorsun. Telefonundaki ağ listesinden kafenin gerçek ağını bul.</p>
        </div>

        <div data-wifi-picker data-requirement="Kafenin gerçek ağını seç" class="mt-6 grid items-start gap-6 lg:grid-cols-[1fr_21rem]">
            <div class="flex flex-col gap-4">
                <div class="bg-signal/15 border-signal rounded-[1.25rem] border-2 border-dashed p-5 sm:p-6">
                    <p class="font-display text-2xl font-extrabold tracking-tight">Mavi Kafe</p>
                    <p class="text-muted mt-1">Kasanın yanındaki tabela</p>
                    <dl class="mt-4 grid grid-cols-[auto_1fr] gap-x-4 gap-y-1 text-lg">
                        <dt class="text-muted">Ağ adı</dt>
                        <dd class="font-mono font-bold">MaviKafe-Misafir</dd>
                        <dt class="text-muted">Şifre</dt>
                        <dd class="font-mono font-bold">kahve2026</dd>
                    </dl>
                </div>

                <div data-wifi-feedback aria-live="polite" class="data-[tone=correct]:border-safe data-[tone=correct]:bg-safe/10 data-[tone=wrong]:border-alert data-[tone=wrong]:bg-alert/8 rounded-xl border-l-4 px-5 py-4 leading-relaxed" hidden>
                    <p data-wifi-feedback-title class="font-bold"></p>
                    <div data-wifi-feedback-body class="mt-1"></div>
                </div>
            </div>

            <x-phone label="Telefonun Wi-Fi ayarları">
                <div class="px-3 pt-2 pb-6">
                    <p class="font-sans px-2 text-lg font-extrabold tracking-tight">Wi-Fi</p>
                    <p class="text-muted px-2 text-sm">Kullanılabilir ağlar</p>
                    <ul class="mt-2 flex flex-col">
                        <x-wifi-network name="MaviKafe-Misafir-FREE" :signal="4">
                            Adı tabeladakiyle birebir aynı değil ve şifresiz. Gerçek ağa benzeyen bu isim tipik bir <strong class="font-bold">kötü ikiz</strong> tuzağı.
                            Sinyalinin en güçlü olması da seni kandırmasın: saldırgan hemen yanındaki masada oturuyor olabilir.
                        </x-wifi-network>
                        <x-wifi-network name="MaviKafe-Misafir" :signal="3" secured real>
                            Adı tabeladakiyle birebir aynı ve şifreli. Yine de unutma: bu ağı kafedeki herkes paylaşıyor.
                            HTTPS olmayan sitelere bilgi girme, önemli işleri mobil veriyle yap.
                        </x-wifi-network>
                        <x-wifi-network name="Mavi Kafe" :signal="2">
                            Adı kafeye benziyor ama tabeladaki ağ bu değil. Emin olmadığın bir ağa bağlanmak yerine personele sor.
                        </x-wifi-network>
                        <x-wifi-network name="Ucretsiz_Internet" :signal="2">
                            Kime ait olduğu belli olmayan, şifresiz bir ağ. Neden ücretsiz internet dağıttığını bilmediğin birinin ağına bağlanma.
                        </x-wifi-network>
                        <x-wifi-network name="Yilmazlar_Ev_5G" :signal="1" secured>
                            Bu, yakındaki bir evin özel ağı. Şifresini bilmiyorsun; bilsen bile izinsiz bağlanmak doğru değil.
                        </x-wifi-network>
                    </ul>
                </div>
            </x-phone>
        </div>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Kafede bağlandığın ağın giriş sayfası, internete erişmek için e-posta adresini ve e-posta parolanı istiyor. Ne yapmalısın?">
                <x-quiz.option>İkisini de yazarım; kafe internetini böyle veriyor.</x-quiz.option>
                <x-quiz.option>Sadece parolamı yazarım, e-posta adresimi yazmam.</x-quiz.option>
                <x-quiz.option correct>Sayfayı kapatırım; Wi-Fi’a bağlanmak için e-posta parolası gerekmez.</x-quiz.option>

                <x-slot:explanation>
                    Halka açık ağların giriş sayfaları en fazla kullanım koşullarını onaylamanı ya da bir kod girmeni ister.
                    Parola isteyen bir sayfa, büyük ihtimalle kötü ikiz bir ağın oltalama tuzağıdır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Halka açık Wi-Fi’da https kullanan bir siteye girdin. Aynı ağdaki bir saldırgan ne görebilir?">
                <x-quiz.option>Her şeyi, yazdığım parola dahil.</x-quiz.option>
                <x-quiz.option correct>Hangi siteye bağlandığımı, ama ne yazdığımı değil.</x-quiz.option>
                <x-quiz.option>Hiçbir şeyi, bağlandığım siteyi bile.</x-quiz.option>

                <x-slot:explanation>
                    HTTPS içeriği şifreler ama bağlanılan sitenin adı (alan adı) yine de görünür. Bunu da gizlemek istersen güvenilir bir VPN kullanabilirsin.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Havalimanında acilen internet bankacılığına girmen gerekiyor. En güvenli seçenek hangisi?">
                <x-quiz.option>Sinyali en güçlü ücretsiz ağa bağlanmak.</x-quiz.option>
                <x-quiz.option>Tarayıcının gizli sekmesini açmak.</x-quiz.option>
                <x-quiz.option correct>Wi-Fi’ı kapatıp mobil veriyle bankanın kendi uygulamasını kullanmak.</x-quiz.option>

                <x-slot:explanation>
                    Gizli sekme sadece geçmişini cihazına kaydetmez; trafiğini ağdaki diğer kişilerden gizlemez.
                    Mobil veri ise başkalarıyla paylaştığın bir ağ değildir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
