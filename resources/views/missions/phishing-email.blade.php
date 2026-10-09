<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Saldırganların çoğu karmaşık hileler yerine sana sadece bir e-posta gönderir ve tıklamanı bekler.
        Bu görevde sahte e-postaları ele veren ipuçlarını öğrenecek, sonra bir gelen kutusunu tek tek inceleyeceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Oltalama nedir?">
        <div class="lesson">
            <p>
                <strong>Oltalama</strong> (İngilizcesiyle <em>phishing</em>), saldırganın güvendiğin bir kurum ya da kişiymiş gibi davranarak
                seni bir bağlantıya tıklamaya, bir dosyayı açmaya veya şifre, kart numarası gibi bilgilerini vermeye kandırmasıdır.
                Adı balık tutmaktan gelir: yem atılır ve birinin yutması beklenir.
            </p>

            <h3>Sahte e-postayı ele veren işaretler</h3>
            <ul>
                <li><strong>Gönderen adresi tutmuyor.</strong> Görünen ad “Mavi Bank” olabilir ama adres <em>@mavibank-destek.xyz</em> gibi alakasız bir yerden gelir. Bazen tek harf farkı vardır: <em>mavibenk</em> gibi.</li>
                <li><strong>Acele ettiriyor ya da korkutuyor.</strong> “24 saat içinde”, “hesabınız kapatılacak”, “son şans”. Amaç, düşünmeden tıklamanı sağlamak.</li>
                <li><strong>Bilgi istiyor.</strong> Şifre, kart numarası ya da doğrulama kodu. Gerçek kurumlar bunları e-postayla istemez.</li>
                <li><strong>Bağlantı başka yere gidiyor.</strong> Düğmede “Hesabımı doğrula” yazar ama bağlantının üzerine geldiğinde görünen adres kurumun gerçek adresi değildir.</li>
                <li><strong>Gerçek olamayacak kadar iyi.</strong> Katılmadığın bir çekilişte kazandığın ödül, beklemediğin bir iade. Bunlar genellikle yemdir.</li>
                <li><strong>Genel hitap.</strong> “Sayın müşterimiz” gibi isimsiz hitaplar. Bankan adını bilir.</li>
            </ul>
        </div>

        <x-callout title="Şüphelendiysen ne yapmalısın?" class="mt-8">
            Bağlantıya tıklama, eki açma, yanıt verme. Kurumun uygulamasını aç ya da adresini tarayıcıya kendin yazarak giriş yap.
            Gerçekten bir sorun varsa orada da görürsün.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Gelen kutusunu incele">
        <div class="lesson">
            <p>
                Ayşe’nin gelen kutusunda beş e-posta var. Her birini dikkatlice oku ve güvenli mi yoksa oltalama mı olduğuna karar ver.
                Bağlantıların üzerine gelerek (telefonda dokunarak) gerçekte nereye gittiklerini görebilirsin.
            </p>
            <p class="text-muted text-base">Bu görevdeki tüm kurumlar, kişiler ve adresler uydurmadır.</p>
        </div>

        <div data-inbox data-requirement="Gelen kutusundaki tüm e-postaları incele" class="mt-6">
            <div class="text-muted mb-3 flex items-baseline justify-between gap-4" data-inbox-progress>
                <p>E-posta <span data-inbox-position class="text-ink font-bold">1</span> / <span data-inbox-total>5</span></p>
                <p>Doğru: <span data-inbox-score class="text-ink font-bold">0</span></p>
            </div>

            <div class="flex flex-col gap-4">
                <x-phishing.email
                    verdict="phishing"
                    from-name="Mavi Bank Güvenlik"
                    from-address="guvenlik@mavibank-destek.xyz"
                    subject="ACİL: Hesabınız askıya alındı!"
                    suspicious-sender
                >
                    <p><span data-clue>Sayın Müşterimiz,</span></p>
                    <p>Hesabınızda şüpheli bir işlem tespit edildi. Güvenliğiniz için hesabınız geçici olarak askıya alınmıştır.</p>
                    <p><span data-clue>24 saat içinde</span> bilgilerinizi doğrulamazsanız hesabınız <span data-clue>kalıcı olarak kapatılacaktır.</span></p>
                    <x-phishing.link url="http://mavibank-dogrulama.xyz/giris" suspicious>Hesabımı doğrula</x-phishing.link>

                    <x-slot:clues>
                        <li>Gönderen adresi <strong class="font-bold">mavibank-destek.xyz</strong>; bankanın gerçek adresi olan mavibank.com.tr değil.</li>
                        <li>“24 saat içinde… kalıcı olarak kapatılacaktır” diyerek seni korkutup acele ettiriyor.</li>
                        <li>“Sayın Müşterimiz” diye genel hitap ediyor. Bankan adını bilir.</li>
                        <li>Bağlantı da sahte bir adrese gidiyor: mavibank-dogrulama.xyz.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="safe"
                    from-name="Hızlı Kargo"
                    from-address="bilgi@hizlikargo.com.tr"
                    subject="Siparişin yola çıktı"
                >
                    <p>Merhaba Ayşe,</p>
                    <p>Mor Kitabevi’nden verdiğin 48213 numaralı sipariş bugün kargoya verildi. Tahmini teslimat süresi 2 iş günü.</p>
                    <p>Kargonu takip etmek için Hızlı Kargo uygulamasına ya da hizlikargo.com.tr adresine girip takip numaranı yazabilirsin: <strong class="font-bold">HK-48213</strong>.</p>
                    <p class="text-muted">Hızlı Kargo sizden hiçbir zaman e-posta ile şifre, kart bilgisi veya ödeme istemez.</p>

                    <x-slot:clues>
                        <li>Gönderen adresi kargo firmasının kendi alan adından geliyor: hizlikargo.com.tr.</li>
                        <li>Sana adınla hitap ediyor ve gerçekten verdiğin bir siparişten bahsediyor.</li>
                        <li>Acele ettirmiyor; senden para ya da bilgi istemiyor.</li>
                        <li>Tıklaman gereken bir bağlantı yok, siteye kendin girmeni öneriyor.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="phishing"
                    from-name="Çekiliş Ekibi"
                    from-address="odul@kazanan-sensin.top"
                    subject="TEBRİKLER!!! Yeni telefonunu kazandın"
                    suspicious-sender
                >
                    <p>Tebrikler! <span data-clue>Bu ayın şanslı ziyaretçisi sensin ve son model bir akıllı telefon kazandın!!!</span></p>
                    <p>Ödülünü alabilmek için sadece <span data-clue>9,90 TL kargo ücretini</span> ödemen gerekiyor. <span data-clue>Kampanya bu gece 23.59’da sona eriyor, acele et!</span></p>
                    <x-phishing.link url="http://kazanan-sensin.top/odeme" suspicious>Ödülümü al</x-phishing.link>

                    <x-slot:clues>
                        <li>Katılmadığın bir çekilişi kazanamazsın. Gerçek olamayacak kadar iyi teklifler genellikle tuzaktır.</li>
                        <li>Küçük bir “kargo ücreti” bahanesiyle kart bilgilerini istiyor.</li>
                        <li>“Bu gece sona eriyor, acele et!” diyerek düşünmeden hareket etmeni istiyor.</li>
                        <li>Gönderen adresi de bağlantı da alakasız bir alan adına ait: kazanan-sensin.top.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="phishing"
                    from-name="Mavi Bank"
                    from-address="bildirim@mavibenk.com.tr"
                    subject="Güvenlik güncellemesi: şifrenizi yenileyin"
                    suspicious-sender
                >
                    <p>Merhaba Ayşe Yılmaz,</p>
                    <p>Güvenlik sistemimizi yeniledik. Hesabınızı korumaya devam edebilmemiz için <span data-clue>şifrenizi aşağıdaki bağlantıdan yenilemeniz</span> gerekiyor.</p>
                    <x-phishing.link url="https://mavibenk.com.tr/sifre-yenile" suspicious>Şifremi yenile</x-phishing.link>
                    <p>Mavi Bank</p>

                    <x-slot:clues>
                        <li>Dikkatli bak: adres mavibank değil, <strong class="font-bold">mavibenk</strong>.com.tr. Saldırganlar gerçeğine çok benzeyen alan adları alır.</li>
                        <li>Adınla hitap etmesi güvenli olduğunu göstermez; bu bilgiler sızıntılardan kolayca bulunabilir.</li>
                        <li>Bağlantının “https” ile başlaması da yetmez. Bu sadece bağlantının şifreli olduğunu gösterir, sitenin kime ait olduğunu değil.</li>
                        <li>Bankalar e-postadaki bir bağlantıdan şifre yenilemeni istemez.</li>
                    </x-slot:clues>
                </x-phishing.email>

                <x-phishing.email
                    verdict="safe"
                    from-name="Mavi Bank"
                    from-address="bildirim@mavibank.com.tr"
                    subject="Ekim ayı hesap özetiniz hazır"
                >
                    <p>Merhaba Ayşe Yılmaz,</p>
                    <p>Ekim ayı hesap özetiniz hazırlandı. Görüntülemek için Mavi Bank mobil uygulamasına ya da internet şubemize giriş yapabilirsiniz.</p>
                    <p class="text-muted">Hatırlatma: Mavi Bank sizden e-posta, SMS ya da telefonla asla şifre, kart bilgisi veya doğrulama kodu istemez.</p>

                    <x-slot:clues>
                        <li>Gönderen adresi bankanın gerçek alan adı: mavibank.com.tr.</li>
                        <li>Senden hiçbir bilgi istemiyor ve bir bağlantıya tıklatmaya çalışmıyor.</li>
                        <li>Acele ettirmiyor ya da korkutmuyor.</li>
                    </x-slot:clues>
                </x-phishing.email>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="button" data-inbox-next class="btn-primary" hidden>Sonraki e-posta</button>
            </div>

            <div data-inbox-summary class="bg-card border-line rounded-[1.25rem] border p-6 sm:p-7" hidden>
                <p data-inbox-summary-score tabindex="-1" class="font-display text-3xl font-extrabold tracking-tight focus:outline-none"></p>
                <p data-inbox-summary-message class="mt-2 max-w-[60ch] text-lg leading-relaxed"></p>
                <button type="button" data-inbox-restart class="btn-secondary mt-5">Gelen kutusunu baştan başlat</button>
            </div>
        </div>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bankandan geldiği söylenen bir e-posta, bir bağlantıdan şifreni girmeni istiyor. Ne yapmalısın?">
                <x-quiz.option>E-postayı yanıtlayıp şifremi yazarım.</x-quiz.option>
                <x-quiz.option>Bağlantıya tıklarım ama giriş yapmadan önce sayfaya bakarım.</x-quiz.option>
                <x-quiz.option correct>Bağlantıya tıklamam; bankanın uygulamasından ya da adresini kendim yazarak kontrol ederim.</x-quiz.option>

                <x-slot:explanation>
                    Sahte sayfalar gerçeğinin birebir kopyası olabilir, bu yüzden “bakıp anlamak” çoğu zaman işe yaramaz.
                    En güvenli yol, kuruma her zaman kendi bildiğin yoldan ulaşmaktır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir bağlantının nereye gittiğini tıklamadan nasıl anlarsın?">
                <x-quiz.option>Düğmenin üzerindeki yazıyı okurum.</x-quiz.option>
                <x-quiz.option correct>Fareyle üzerine gelirim (telefonda basılı tutarım) ve görünen gerçek adresi kontrol ederim.</x-quiz.option>
                <x-quiz.option>Anlayamam, tıklamam gerekir.</x-quiz.option>

                <x-slot:explanation>
                    Düğmede ne yazdığının önemi yok; saldırgan oraya istediğini yazabilir. Önemli olan bağlantının gittiği gerçek adrestir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Gönderen adı “Mavi Bank” görünüyor. Bu, e-postanın gerçekten bankadan geldiğini gösterir mi?">
                <x-quiz.option>Evet, ad doğruysa e-posta da gerçektir.</x-quiz.option>
                <x-quiz.option correct>Hayır. Görünen adı herkes istediği gibi yazabilir, asıl bakılması gereken e-posta adresidir.</x-quiz.option>

                <x-slot:explanation>
                    Görünen ad sadece bir etikettir. Köşeli parantez içindeki adrese, özellikle de @ işaretinden sonraki alan adına bak.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
