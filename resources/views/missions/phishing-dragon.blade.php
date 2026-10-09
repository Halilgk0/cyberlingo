<x-layouts.mission :mission="$mission" :steps="['hazirlik' => 'Hazırlık', 'ejderha' => 'Ejderhayla yüzleş']">
    <x-slot:intro>
        Bölümün son kapısında ejderha bekliyor: şimdiye kadar gördüğün en ustaca hazırlanmış e-postalar. Bu sınavda her ipucu yazmıyor;
        öğrendiklerinle kendin bulacaksın. Beş e-postanın en az dördünü doğru bilirsen ejderhayı yenersin.
    </x-slot:intro>

    <x-mission.step id="hazirlik" number="1" title="Ejderhanın beş hilesi">
        <div class="lesson">
            <p>Usta oltacılar yazım hatası yapmaz, korkutucu büyük harfler kullanmaz. Onları ele veren daha ince izlerdir:</p>
            <ol>
                <li><strong>Kılık değiştirmiş harfler:</strong> Kiril alfabesindeki “а”, Latin “a”nın tıpatıp aynısıdır. Bu yüzden “mavibаnk.com.tr” gerçeğinden ayırt edilemez. Tarayıcılar böyle adresleri <em>xn--</em> ile başlayan gerçek halleriyle gösterir; bağlantının üzerine gelince bunu yakalarsın.</li>
                <li><strong>Tanıdık birinin adı:</strong> Müdüründen, öğretmeninden ya da bir aile büyüğünden geliyormuş gibi görünen, acele ve gizlilik isteyen ödeme talepleri. “Yanıtla” adresine bak; şüphelenirsen kişiyi bildiğin bir numaradan ara.</li>
                <li><strong>Gerçek hizmetin kılığı:</strong> Belge paylaşımı ya da kargo bildirimi gibi gerçek hizmetlerin e-postaları kopyalanır. Her zaman bağlantının alan adını oku.</li>
                <li><strong>QR kodlar:</strong> Bir QR kod gittiği adresi gizler. Tarattığında açılan adresi okumadan hiçbir bilgi girme.</li>
                <li><strong>Gerçek uyarılar da vardır:</strong> Her güvenlik e-postası sahte değildir. Gerçek bir uyarı genellikle seni bir bağlantıya değil, uygulamanın kendisine yönlendirir.</li>
            </ol>
        </div>

        <x-callout tone="warning" title="Sınavın kuralı" class="mt-8">
            Beş e-postadan en az dördünü doğru bilmelisin. Ejderha kazanırsa gelen kutusunu baştan başlatıp yeniden deneyebilirsin.
            Bağlantıların üzerine gelmeyi (telefonda dokunmayı) unutma.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="ejderha" number="2" title="Ejderhayla yüzleş">
        <div class="lesson">
            <p class="text-muted text-base">Bu sınavdaki bütün kurumlar, kişiler ve adresler uydurmadır.</p>
        </div>

        <div data-inbox data-pass-score="4" data-requirement="Ejderha sınavını en az 4 doğruyla geç" class="mt-4">
            <div class="text-muted mb-3 flex items-baseline justify-between gap-4" data-inbox-progress>
                <p>E-posta <span data-inbox-position class="text-ink font-bold">1</span> / <span data-inbox-total>5</span></p>
                <p>Doğru: <span data-inbox-score class="text-ink font-bold">0</span> · Geçmek için 4</p>
            </div>

            <div class="flex flex-col gap-4">
                <x-phishing.email
                    verdict="phishing"
                    from-name="Mavi Bank"
                    from-address="guvenlik@mavibаnk.com.tr"
                    subject="Hesabınızda olağan dışı giriş denemesi"
                    suspicious-sender
                >
                    <p>Merhaba Ayşe Yılmaz,</p>
                    <p>Hesabınıza bugün yurt dışından bir giriş denemesi yapıldığını tespit ettik. Siz değilseniz kimliğinizi doğrulayarak hesabınızı koruma altına alabilirsiniz.</p>
                    <x-phishing.link url="https://xn--mavibnk-6fg.com.tr/dogrula" suspicious>Kimliğimi doğrula</x-phishing.link>
                    <p class="text-muted">Mavi Bank Güvenlik Ekibi</p>

                    <x-slot:clues>
                        <li>Adres “mavibank” gibi görünüyor ama içindeki “а” harfi Kiril alfabesinden. Bağlantının üzerine gelince tarayıcı gerçek adı gösteriyor: <strong class="font-bold">xn--mavibnk-6fg.com.tr</strong>, yani bambaşka bir alan adı.</li>
                        <li>Sakin dili ve adınla hitap etmesi seni kandırmasın; bu bilgiler sızıntılardan kolayca bulunur.</li>
                        <li>Gerçek bir banka uyarısı seni e-postadaki bir bağlantıya değil, bankanın uygulamasına yönlendirir.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="phishing"
                    from-name="Mert Kaya (Genel Müdür)"
                    from-address="mert.kaya@renkli-ajans.example"
                    reply-to="mertkaya.gm@eposta-hizmeti.example"
                    subject="Acil ve gizli: bugün yapılması gereken ödeme"
                >
                    <p>Ayşe merhaba,</p>
                    <p>Şu an bir toplantıdayım, telefonla konuşamıyorum. Yeni tedarikçimize <span data-clue>bugün mesai bitmeden</span> 186.400 TL ödememiz gerekiyor. <span data-clue>IBAN bilgileri değişti</span>, yenisini aşağıya yazıyorum.</p>
                    <p class="font-mono">TR12 0006 4000 0011 2345 6789 01</p>
                    <p><span data-clue>Bu konuyu şimdilik kimseyle paylaşma</span>, işlem bitince bana bu e-postadan dön.</p>
                    <p>Mert</p>

                    <x-slot:clues>
                        <li>“Yanıtla” adresi şirketin adresi değil: <strong class="font-bold">mertkaya.gm@eposta-hizmeti.example</strong>. Cevabın doğrudan dolandırıcıya gider.</li>
                        <li>Acele, gizlilik ve “telefonla ulaşamazsın” üçlüsü, yönetici kılığındaki dolandırıcılığın (CEO dolandırıcılığı) imzasıdır.</li>
                        <li>IBAN değişikliğini her zaman bildiğin bir telefon numarasından sesli olarak doğrula.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="safe"
                    from-name="Zeynep Arslan (BelgeBulut)"
                    from-address="bildirim@belgebulut.example"
                    subject="Zeynep sizinle “Ekim kampanya planı” belgesini paylaştı"
                >
                    <p>Zeynep Arslan sizinle bir belge paylaştı: <strong class="font-bold">Ekim kampanya planı</strong></p>
                    <p class="border-line border-l-4 pl-3 italic">“Ayşe, dün toplantıda konuştuğumuz plan bu. Yorumlarını cuma gününe kadar bekliyorum.”</p>
                    <x-phishing.link url="https://belgebulut.example/d/8F3kQ2">Belgeyi aç</x-phishing.link>

                    <x-slot:clues>
                        <li>Bağlantı paylaşım hizmetinin kendi alan adına gidiyor: belgebulut.example.</li>
                        <li>Mesaj, dün konuştuğun ve beklediğin bir işe dair; acele ettirmiyor.</li>
                        <li>Ne parola ne ödeme istiyor. Belgeyi açınca giriş sayfası çıkarsa adresi yine kontrol et.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="safe"
                    from-name="posta.example"
                    from-address="guvenlik@posta.example"
                    subject="Hesabına yeni bir cihazdan giriş yapıldı"
                >
                    <p>Merhaba Ayşe,</p>
                    <p>Hesabına 9 Ekim 2026, 21.14’te Ankara’dan, Windows yüklü bir bilgisayardan giriş yapıldı.</p>
                    <p>Bu sen değilsen, posta.example uygulamasında <strong class="font-bold">Ayarlar › Güvenlik</strong> bölümünden parolanı değiştir ve diğer cihazlardan çıkış yap.</p>
                    <p class="text-muted">Güvenliğin için bu e-postada bağlantı bulunmaz.</p>

                    <x-slot:clues>
                        <li>Gönderen, posta.example’ın kendi alan adı.</li>
                        <li>Bağlantı yok; seni uygulamanın kendisine yönlendiriyor.</li>
                        <li>Hiçbir bilgi istemiyor. Yine de giriş sen değilsen hemen uygulamadan parolanı değiştir.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="phishing"
                    from-name="Hızlı Kargo Gümrük"
                    from-address="gumruk@hizlikargo-tr.top"
                    subject="Gümrük ücreti ödenmediği için paketiniz bekletiliyor"
                    suspicious-sender
                >
                    <p>Sayın alıcı,</p>
                    <p>Yurt dışından gelen paketiniz için <span data-clue>38,50 TL gümrük ücreti</span> ödenmemiştir. Ödemeyi <span data-clue>48 saat içinde</span> telefonunuzla aşağıdaki QR kodu okutarak yapabilirsiniz.</p>
                    <div class="flex items-center gap-4">
                        <x-fake-qr seed="gumruk" class="size-28 shrink-0 rounded-lg" />
                        <p class="text-muted text-base">Telefonunuzun kamerasıyla okutun.</p>
                    </div>

                    <x-slot:clues>
                        <li>Gönderen adresi <strong class="font-bold">hizlikargo-tr.top</strong>; kargo firmasının alan adı hizlikargo.com.tr.</li>
                        <li>QR kod gittiği adresi gizliyor. Bu kod <strong class="font-bold">hizlikargo-gumruk.top/ode</strong> adresine götürüyor.</li>
                        <li>Küçük bir ücret ve süre baskısı, kart bilgini almak için kullanılan klasik bir yemdir.</li>
                    </x-slot:clues>
                </x-phishing.email>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="button" data-inbox-next class="btn-primary" hidden>Sonraki e-posta</button>
            </div>

            <div data-inbox-summary class="bg-card border-line riveted rounded-[1.25rem] border-2 p-6 sm:p-7" hidden>
                <p data-inbox-summary-score tabindex="-1" class="font-display text-4xl font-extrabold focus:outline-none"></p>
                <p data-inbox-summary-message class="mt-2 max-w-[60ch] text-lg leading-relaxed"></p>
                <button type="button" data-inbox-restart class="btn-secondary mt-5">Gelen kutusunu baştan başlat</button>
            </div>
        </div>
    </x-mission.step>
</x-layouts.mission>
