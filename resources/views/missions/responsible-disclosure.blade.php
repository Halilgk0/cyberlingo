<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'plan' => 'Planı kur', 'sina' => 'Sına']">
    <x-slot:intro>
        Bazen bir açık seni bulur: bir sayfada başkasına ait bir bilgi görürsün ya da bir şeyin olması gerektiği gibi çalışmadığını fark edersin.
        O anda yapacakların, senin bir kahraman mı yoksa bir suçlu mu olacağını belirler. Bu görevde açığı doğru yoldan bildirmeyi öğreneceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Sorumlu bildirim nedir?">
        <div class="lesson">
            <p>
                <strong>Sorumlu bildirim</strong>, bir güvenlik açığını önce yalnızca sistemin sahibine haber vermek, düzeltmesi için ona zaman tanımak ve
                ancak açık kapandıktan sonra konuşmaktır. Amaç, açığı kötü niyetli birinin bulmasından önce kapatmaktır.
            </p>

            <h3>Bir açığa rastladığında</h3>
            <ul>
                <li><strong>Dur.</strong> Bir açığı fark etmek suç değildir. Ama “emin olmak için” başka şeyler denemek ya da başkalarının verilerine bakmaya devam etmek izinsiz erişime dönüşür.</li>
                <li><strong>Veriye dokunma.</strong> Kanıt olsun diye bile kimsenin kişisel bilgisini indirme, kopyalama ya da paylaşma.</li>
                <li><strong>Kısa not al.</strong> Tarih, sayfanın adresi ve ne gördüğün yeter.</li>
                <li><strong>Resmi kanalı bul.</strong> Birçok sitenin adresinin sonuna <code>/.well-known/security.txt</code> eklersen kime yazacağını gösteren bir dosya bulursun. “Güvenlik açığı bildir” sayfası ya da bir hata ödül programı da olabilir.</li>
                <li><strong>Sabırlı ol.</strong> Düzeltmek zaman alır. Açık kapanmadan sosyal medyada paylaşmak, onu kötü niyetlilere göstermek demektir.</li>
            </ul>

            <h3>Hata ödül programları</h3>
            <p>
                Pek çok şirket, açık bulup bildirenlere para ya da teşekkür veren <strong>hata ödül programları</strong> yürütür. Bu programlar bir tür izindir,
                ama kuralları vardır: hangi sistemlerin <strong>kapsamda</strong> olduğu, hangi denemelerin yasak olduğu yazar. Kapsam dışındaki her deneme
                yine izinsiz sayılır. Ödülü şirket kendi kurallarıyla verir; ödül istemek için şirketi sıkıştırmak ise şantajdır.
            </p>

            <h3>İyi bir raporda neler olur?</h3>
            <ol>
                <li>Kısa bir başlık: sorunun ne olduğu.</li>
                <li>Nerede olduğu: sayfanın adresi, hangi düğme ya da form.</li>
                <li>Adım adım nasıl karşılaştığın, böylece ekip sorunu kendisi görebilsin.</li>
                <li>Olası etkisi: kimin hangi bilgisi tehlikede.</li>
                <li>İletişim bilgin. Başkalarının verilerini rapora eklemezsin.</li>
            </ol>
        </div>
    </x-mission.step>

    <x-mission.step id="plan" number="2" title="Bildirim planını kur">
        <div class="lesson">
            <p>
                Bir kargo sitesinde kendi faturanı açtın. Adres çubuğundaki fatura numarasını yanlışlıkla bir eksik yazınca karşına başka birinin adı, adresi
                ve telefonu çıktı. Ne yapacağını sırayla seç; üç tuzağa dikkat.
            </p>
            <p class="text-muted text-base">Site ve kişiler uydurmadır.</p>
        </div>

        <x-response-plan requirement="Sorumlu bildirim planını kur" title="Bildirim planın" class="mt-6">
            <x-response-plan.step trap>
                Kanıt olsun diye birkaç kişinin daha faturasını açıp kaydet.

                <x-slot:why>
                    “Kanıt toplamak” bahanesiyle başkalarının bilgilerine bakmak ve onları saklamak izinsiz erişimdir. Bir örnek görmen raporlamak için yeter.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="3">
                Sitenin resmi bildirim kanalını bul: security.txt dosyası, “güvenlik açığı bildir” sayfası ya da müşteri hizmetleri.

                <x-slot:why>
                    Doğru kişiye ulaşmak, açığın hızla kapanmasını sağlar. Rastgele bir sosyal medya hesabına yazmak yerine resmi kanal kullanılır.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="1">
                Dur ve sayfayı kapat; başka numaraları denemeye devam etme.

                <x-slot:why>
                    Bir açığa rastlamak suç değildir. Ama denemeye devam etmek, rastlantıyı bilerek yapılan izinsiz erişime çevirir.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step trap>
                Ekran görüntüsünü sosyal medyada paylaş; baskı olsun da hemen düzeltsinler.

                <x-slot:why>
                    Bu hem o kişinin bilgilerini herkese açar hem de açık kapanmadan kötü niyetlilere yol gösterir. Açık kapandıktan sonra bile
                    başkalarının verisi paylaşılmaz.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="4">
                Sakin ve açık bir rapor yaz: sorun ne, hangi sayfada, sen nasıl karşılaştın ve kimin bilgileri tehlikede.

                <x-slot:why>
                    İyi bir rapor, ekibin sorunu hızla bulmasını sağlar. Gördüğün kişinin bilgilerini rapora yazmazsın; “başka birinin faturası açıldı” demen yeterli.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="2">
                Ne gördüğünü kısaca not al: tarih, saat ve hangi sayfada olduğu. Kimsenin bilgisini kopyalama.

                <x-slot:why>
                    Raporu yazarken neyin nerede olduğunu hatırlaman gerekir. Ama not, başkasının kişisel verisini değil, sorunun yerini anlatır.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step trap>
                Şirkete “Ödül vermezseniz açığı yayınlarım” diye yaz.

                <x-slot:why>
                    Bu şantajdır ve suçtur. Hata ödül programı varsa ödülü şirket kendi kurallarıyla verir; yoksa bildirim karşılıksız yapılır.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="5">
                Düzeltmeleri için zaman tanı; açık kapanmadan kimseyle paylaşma.

                <x-slot:why>
                    Bir açığı kapatmak günler ya da haftalar sürebilir. Sabırlı olmak, o sırada kimsenin açığı kötüye kullanmamasını sağlar.
                </x-slot:why>
            </x-response-plan.step>

            <x-slot:summary>
                Dur, not al, doğru kişiyi bul, açık bir rapor yaz ve bekle. Sorumlu bildirim, bir rastlantıyı binlerce kişiyi koruyan bir iyiliğe çevirir.
            </x-slot:summary>
        </x-response-plan>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bir sitenin security.txt dosyası ne işe yarar?">
                <x-quiz.option>Sitenin parolalarını saklar.</x-quiz.option>
                <x-quiz.option correct>Güvenlik açığı bildirmek isteyenlerin kime ve nasıl ulaşacağını gösterir.</x-quiz.option>
                <x-quiz.option>Sitenin virüs taramasından geçtiğini kanıtlar.</x-quiz.option>

                <x-slot:explanation>
                    security.txt, sitelerin <code>/.well-known/security.txt</code> adresine koyduğu standart bir dosyadır. İçinde güvenlik ekibinin iletişim
                    bilgisi ve bildirim kuralları yazar.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir hata ödül programında neden “kapsam” önemlidir?">
                <x-quiz.option correct>Yalnızca kapsamda yazan sistemleri denemeye iznin vardır; dışındakiler izinsiz sayılır.</x-quiz.option>
                <x-quiz.option>Kapsam, ödülün ne kadar olacağını gösterir; denemelerle ilgisi yoktur.</x-quiz.option>
                <x-quiz.option>Kapsam yalnızca şirket çalışanları içindir.</x-quiz.option>

                <x-slot:explanation>
                    Hata ödül programı bir izindir ve izin sınırlıdır. Kapsam dışındaki bir sunucuyu denemek, programa katılmış olsan bile izinsiz giriştir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="İyi bir açık raporunda hangisi yer almamalı?">
                <x-quiz.option>Sorunun hangi sayfada olduğu.</x-quiz.option>
                <x-quiz.option>Ekibin sorunu görebilmesi için adım adım anlatım.</x-quiz.option>
                <x-quiz.option correct>Gördüğün başka kişilerin adları, adresleri ve telefonları.</x-quiz.option>

                <x-slot:explanation>
                    Rapor sorunu anlatır, başkalarının verilerini taşımaz. “Başka bir müşterinin faturası açıldı” demek ekibin anlaması için yeterlidir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
