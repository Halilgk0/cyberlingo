<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'ayir' => 'Ayır', 'sina' => 'Sına']">
    <x-slot:intro>
        Bir kaleyi düşürmenin tek yolu surları aşmak değildir; kapının önünü öyle bir kalabalıkla doldurursun ki içeri gerçekten girmesi
        gerekenler giremez. İnternette bunun adı hizmet engelleme saldırısı. Bu görevde bu saldırının ne olduğunu, nasıl ortaya çıktığını ve bir
        siteyi ona karşı nasıl savunacağını öğreneceksin. Burada hiçbir saldırı yöntemi anlatılmaz; yalnızca savunma.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Kapının önündeki kalabalık">
        <div class="lesson">
            <p>
                <strong>Hizmet engelleme saldırısı</strong> (DoS), bir hizmeti gerçek kullanıcıların erişemeyeceği kadar yoğun istekle meşgul etmektir.
                Sunucu da bir dükkân gibidir: aynı anda ancak belirli sayıda müşteriye bakabilir. Kapıyı sahte bir kalabalıkla doldurursan, gerçek
                müşteriler içeri giremez.
            </p>

            <h3>Neden “dağıtık”? (DDoS)</h3>
            <p>
                Tek bir kaynaktan gelen aşırı trafik kolayca fark edilip engellenir: o adresi kapatırsın, biter. Bu yüzden saldırganlar trafiği binlerce
                farklı kaynağa yayar. Buna <strong>dağıtık hizmet engelleme</strong> (DDoS) denir. “Dağıtık” olması savunmayı zorlaştırır, çünkü bu kadar çok
                kaynağı gerçek kullanıcılardan ayırmak kolay değildir.
            </p>

            <h3>Bu kaynaklar nereden geliyor?</h3>
            <p>
                Çoğu zaman o binlerce cihazın sahipleri olup bitenden habersizdir. Zararlı yazılım bulaşmış bilgisayarlar, güncellenmemiş kameralar,
                yönlendiriciler ve akıllı ev cihazları (IoT) bir <strong>botnet</strong>e, yani uzaktan yönetilen bir “zombi ordusuna” dönüştürülür. Saldırgan
                tek bir komutla bu orduya aynı hedefe trafik göndertir. Zararlı yazılım görevinde öğrendiğin alışkanlıklar, cihazının bu ordunun bir askeri
                olmasını önleyen şeydir: güncelleme ve varsayılan parolaları değiştirmek.
            </p>

            <h3>Üç tür, tek amaç</h3>
            <ul>
                <li><strong>Hacim temelli:</strong> Hedefin internet bağlantısını devasa trafikle doldurur, yol tıkanır.</li>
                <li><strong>Protokol temelli:</strong> Bağlantı kurma adımlarını tüketerek sunucunun kaynaklarını bitirir.</li>
                <li><strong>Uygulama katmanı:</strong> Sitenin en pahalı, en yorucu sayfalarını (örneğin arama) az ama akıllı istekle hedefler.</li>
            </ul>
            <p>Hepsinin amacı aynıdır: hizmeti gerçek kullanıcılara kapatmak.</p>

            <h3>Neden yapılır?</h3>
            <p>
                Durdurmak için fidye istemek, bir rakibi satış gününde çökertmek, dikkati dağıtıp arka planda başka bir saldırıyı gizlemek ya da protesto.
                Sebebi ne olursa olsun, <strong>izinsiz hizmet engelleme bir suçtur.</strong>
            </p>

            <h3>Bir savunucu ne yapar?</h3>
            <ul>
                <li><strong>Önce doğrular.</strong> Her ani yoğunluk saldırı değildir; bir indirim ya da viral bir paylaşım da olabilir. Panikle gerçek kullanıcıları dışarıda bırakmamak gerekir.</li>
                <li><strong>Hız sınırlama uygular.</strong> Tek bir kaynaktan gelen aşırı isteği yavaşlatır. CyberLingo’nun üst üste beş hatalı girişten sonra girişi kısıtlaması da küçük bir örneğidir.</li>
                <li><strong>Trafiği süzdürür.</strong> Büyük bir CDN ya da koruma sağlayıcısı, saldırı trafiğini temizleyip gerçek kullanıcıyı geçirir.</li>
                <li><strong>Doğrulama sayfaları koyar.</strong> “İnsan mısın?” denetimi, botların çoğunu eler.</li>
                <li><strong>Yükü dağıtır.</strong> Önbellek ve ölçeklenebilir altyapı, saldırı sürerken bile sitenin ayakta kalmasına yardım eder.</li>
                <li><strong>Hazırlıklı olur.</strong> Sağlayıcısının kimi arayacağını, planın ne olduğunu saldırı gelmeden bilir.</li>
            </ul>
        </div>

        <x-callout tone="warning" title="Denemek yasal mı?" class="mt-8">
            Bir sisteme izinsiz yük bindirmek, yalnızca “denemek” için bile olsa hizmet engelleme sayılır ve Türk Ceza Kanunu’nda sistemin işleyişini
            engelleme suçu kapsamına girer. Para karşılığı saldırı düzenleyen <strong class="font-bold">kiralık saldırı hizmetlerini</strong> kullanmak da
            aynı şekilde suçtur. Bir sistemin dayanıklılığını ölçmek <strong class="font-bold">yük testi</strong>dir ve yalnızca kendi sistemin üzerinde ya
            da yazılı izinle, kontrollü bir ortamda yapılır.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="ayir" number="2" title="Saldırı mı, gerçek yoğunluk mu?">
        <div class="lesson">
            <p>
                İyi bir savunucunun ilk işi, bir yoğunluğun gerçek mi yoksa saldırı mı olduğunu anlamaktır. Gerçek kullanıcılar çeşitli davranır:
                farklı sayfalara bakar, zaman geçirir, alışverişi tamamlar. Saldırı trafiği ise tekdüzedir, hiçbir şeyi bitirmez ve çoğu zaman tuhaf
                kaynaklardan gelir. Altı durumu oku ve her birini doğru kutuya koy.
            </p>
            <p class="text-muted text-base">Bu görevdeki durumlar uydurmadır.</p>
        </div>

        <x-sorter
            :categories="['gercek' => 'Gerçek yoğunluk', 'saldiri' => 'Saldırı belirtisi']"
            question="Bu yoğunluk ne?"
            requirement="Altı durumu doğru ayır"
            class="mt-6"
        >
            <x-sorter.card answer="gercek" label="İndirim sabahı">
                Sabah 10’da indirim başladı. Binlerce ziyaretçi farklı ürünlere bakıyor, yorumları okuyor, bir kısmı sepet oluşturup alışverişi tamamlıyor.

                <x-slot:explanation>
                    Gerçek kullanıcılar çeşitli davranır ve işlemleri tamamlar. Beklenen bir kampanya yoğunluğu, planlanabilen normal bir trafiktir.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="saldiri" label="Aynı istek, binlerce kez">
                Yüzlerce farklı adres, saniyede binlerce kez tam olarak aynı sayfayı istiyor. Hiçbiri başka bir şeye tıklamıyor, hiçbiri alışveriş yapmıyor.

                <x-slot:explanation>
                    Tekdüze, tamamlanmayan ve anlamsız biçimde tekrar eden trafik, bir saldırının klasik imzasıdır. Gerçek kullanıcı aynı sayfayı saniyede binlerce kez istemez.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="gercek" label="Viral video">
                Bir ürün videosu çok paylaşıldı. Ziyaretçi sayısı birkaç saatte arttı; trafik farklı ülkelerden gerçek kişilerden geliyor, sayfada zaman geçiriyorlar.

                <x-slot:explanation>
                    Ani ama açıklanabilir bir artış. Kullanıcılar sayfada geziniyor ve davranışları çeşitli; bu bir saldırı değil, bir fırsat.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="saldiri" label="Güncellenmemiş cihaz ordusu">
                Trafiğin büyük bölümü, dünyanın dört bir yanındaki güncellenmemiş kameralardan ve yönlendiricilerden geliyor; hiçbiri sitenin normal ziyaretçisine benzemiyor.

                <x-slot:explanation>
                    Ele geçirilmiş IoT cihazlarından oluşan bir botnet işareti. Sahipleri bundan habersizdir; cihazları onların adına saldırıyor.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="saldiri" label="Tek bir pahalı sayfaya yük">
                Trafik bir anda sıçradı ve tamamı sitenin en yorucu sayfasına, arama motoruna biniyor. Başka hiçbir sayfa ziyaret edilmiyor.

                <x-slot:explanation>
                    Yalnızca en pahalı uç noktayı hedefleyen, başka hiçbir doğal davranış göstermeyen trafik, bir uygulama katmanı saldırısına işaret eder.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="gercek" label="Bülten dalgası">
                Akşam 20:00’de e-bültenini gönderdin. Abonelerden düzenli bir tık dalgası geldi; çoğu giriş yapıp kaldığı yerden okumaya devam etti.

                <x-slot:explanation>
                    Kendi tetiklediğin, beklenen bir yoğunluk. Kullanıcılar giriş yapıp içerikle etkileşiyor; bu olağan bir trafiktir.
                </x-slot:explanation>
            </x-sorter.card>

            <x-slot:summary>
                Gerçek yoğunluğu saldırıdan ayıran şey davranıştır: gerçek kullanıcılar çeşitli davranır ve işleri tamamlar, saldırı trafiği tekdüzedir ve
                hiçbir şeyi bitirmez. Saldırı olduğundan emin olunca sıra savunmaya gelir: hız sınırlama, süzme ve sağlayıcıyla iş birliği.
            </x-slot:summary>
        </x-sorter>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bir saldırı neden tek kaynak yerine binlerce kaynağa (DDoS) yayılır?">
                <x-quiz.option>Çünkü böylesi daha ucuzdur.</x-quiz.option>
                <x-quiz.option correct>Çünkü tek kaynak kolayca engellenir; binlerce kaynağı gerçek kullanıcılardan ayırmak zordur.</x-quiz.option>
                <x-quiz.option>Çünkü tek bir bilgisayar internete bağlanamaz.</x-quiz.option>

                <x-slot:explanation>
                    Dağıtık olmanın tek amacı savunmayı zorlaştırmaktır. Trafik ne kadar çok ve çeşitli kaynaktan gelirse, onu gerçek ziyaretçiden ayırmak o kadar güçleşir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Cihazının bir botnet’in parçası olmasını en çok ne önler?">
                <x-quiz.option>Cihazı sürekli kapatıp açmak.</x-quiz.option>
                <x-quiz.option correct>Güncellemeleri yapmak ve cihazların varsayılan parolalarını değiştirmek.</x-quiz.option>
                <x-quiz.option>İnterneti yalnızca gece kullanmak.</x-quiz.option>

                <x-slot:explanation>
                    Botnet’ler çoğunlukla güncellenmemiş ve varsayılan parolası değiştirilmemiş cihazları ele geçirir. Bu iki alışkanlık, kameranı ya da yönlendiricini bir saldırının askeri olmaktan korur.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Siten ani bir trafik sıçramasıyla karşılaştı. Doğru ilk adım hangisi?">
                <x-quiz.option>Hemen karşı saldırıya geçip trafiğin geldiği adreslere aynısını göndermek.</x-quiz.option>
                <x-quiz.option correct>Bunun gerçek bir yoğunluk mu yoksa saldırı mı olduğunu doğrulamak, sonra hız sınırlama ve süzme devreye almak.</x-quiz.option>
                <x-quiz.option>Siteyi tamamen kapatıp saldırganın para talebini ödemek.</x-quiz.option>

                <x-slot:explanation>
                    Önce teşhis: bir indirim ya da viral paylaşımı saldırı sanıp gerçek kullanıcıları dışarıda bırakmamak gerekir. Karşı saldırı suçtur ve
                    çoğu zaman masum, ele geçirilmiş cihazlara zarar verir; fidye ödemek ise saldırıyı teşvik eder ve bitmesini garanti etmez.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
