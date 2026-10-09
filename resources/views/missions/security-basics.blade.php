<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Hiçbir şey bilmiyorsan doğru yerdesin. Bu görevde siber güvenliğin ne olduğunu, saldırganların senden ne istediğini
        ve korumaya çalıştığımız üç temel şeyi öğreneceksin. Sonra gerçek hayattan olayları doğru kutulara yerleştireceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Siber güvenlik nedir?">
        <div class="lesson">
            <p>
                <strong>Siber güvenlik</strong>, telefonunu, bilgisayarını, internetteki hesaplarını ve bunların içindeki bilgileri
                izinsiz kişilere karşı koruma işidir. Fotoğrafların, mesajların, banka hesabın, okul ya da iş dosyaların… Hepsi bu korumanın konusu.
            </p>
            <p>
                Siber güvenlik sadece uzmanların işi değil. Saldırıların çoğu, herkesin edinebileceği birkaç basit alışkanlıkla durdurulabilir:
                güçlü parolalar kullanmak, şüpheli bağlantılara tıklamamak, güncellemeleri ertelememek.
            </p>

            <h3>Saldırganlar senden ne ister?</h3>
            <p>“Benim neyim var ki, kim benimle uğraşsın?” diye düşünebilirsin. Ama saldırganların aradığı şeylerin çoğu sende de var:</p>
            <ul>
                <li><strong>Paran:</strong> Banka hesabın, kart bilgilerin ya da seni ödeme yapmaya ikna edecek bir hikâye.</li>
                <li><strong>Hesapların:</strong> Ele geçirilen bir sosyal medya hesabından arkadaşlarına mesaj atılıp para istenebilir.</li>
                <li><strong>Bilgilerin:</strong> Kimlik numaran, adresin, telefon numaran. Bunlar başka dolandırıcılıklarda kullanılmak üzere satılır.</li>
                <li><strong>Cihazın:</strong> Bilgisayarın kilitlenip açmak için para istenebilir ya da senden habersiz başka saldırılarda kullanılabilir.</li>
            </ul>
            <p>
                Üstelik saldırıların çoğu kişiye özel değildir. Aynı sahte mesaj aynı anda binlerce kişiye gönderilir ve birinin takılması beklenir.
                Yani hedef olmak için ünlü ya da zengin olman gerekmez.
            </p>

            <h3>Korumaya çalıştığımız üç şey</h3>
            <p>Uzmanlar, korunması gereken her şeyi üç başlıkta toplar. Bunları bilince bir saldırının neye zarar verdiğini hemen anlarsın:</p>
            <ol>
                <li><strong>Gizlilik:</strong> Bilgini sadece görmesi gereken kişiler görebilmeli. Mesajlarını bir yabancının okuması gizliliği bozar.</li>
                <li><strong>Bütünlük:</strong> Bilgin izinsiz değiştirilmemeli. Bir faturadaki IBAN’ın gizlice değiştirilmesi bütünlüğü bozar.</li>
                <li><strong>Erişilebilirlik:</strong> İhtiyacın olduğunda bilgine ve hizmetlere ulaşabilmelisin. Fotoğraflarının kilitlenip sana açılmaması erişilebilirliği bozar.</li>
            </ol>

            <h3>Bilmen gereken ilk kelimeler</h3>
            <p>Bu kelimeleri sonraki görevlerde ve haberlerde sık sık göreceksin.</p>
        </div>

        <dl class="mt-6 grid gap-3 sm:grid-cols-2">
            @foreach ([
                'Zararlı yazılım' => 'Cihazına zarar vermek ya da bilgilerini çalmak için yazılmış program. Virüs de bir zararlı yazılım türüdür.',
                'Fidye yazılımı' => 'Dosyalarını kilitleyip açmak için senden para isteyen zararlı yazılım.',
                'Oltalama' => 'Güvendiğin biri gibi görünerek seni bir bağlantıya tıklamaya ya da bilgilerini vermeye kandıran sahte mesaj veya site.',
                'Güncelleme' => 'Yazılımdaki güvenlik açıklarını kapatan düzeltme. Telefonun ya da bilgisayarın güncelleme isterse erteleme.',
                'İki adımlı doğrulama' => 'Parolana ek olarak ikinci bir kanıt, örneğin telefonuna gelen bir kod isteyen koruma.',
                'Yedek' => 'Dosyalarının ayrı bir yerde tutulan kopyası. Cihazına bir şey olursa dosyalarını geri getirmeni sağlar.',
            ] as $term => $definition)
                <div class="bg-card border-line rounded-2xl border p-5">
                    <dt class="font-display text-xl font-extrabold tracking-tight">{{ $term }}</dt>
                    <dd class="text-muted mt-1.5 leading-relaxed">{{ $definition }}</dd>
                </div>
            @endforeach
        </dl>

        <x-callout title="Mükemmel güvenlik yoktur, amaç işi zorlaştırmak" class="mt-8">
            Kapını kilitlemek hırsızlığı imkânsız kılmaz, ama hırsız genellikle kilitsiz kapıyı seçer. İnternette de saldırganlar
            en kolay hedefi arar. Bu görevlerde öğreneceğin alışkanlıklar seni o kolay hedef olmaktan çıkarır.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Olayları kutulara yerleştir">
        <div class="lesson">
            <p>
                Aşağıda gerçek hayattan alınmış altı olay var. Her birini oku ve en çok neye zarar verdiğine karar ver:
                gizliliğe mi, bütünlüğe mi, erişilebilirliğe mi? Doğru kutuyu bulduğunda olay o kutuya yerleşir.
            </p>
        </div>

        <x-sorter
            :categories="['gizlilik' => 'Gizlilik', 'butunluk' => 'Bütünlük', 'erisilebilirlik' => 'Erişilebilirlik']"
            question="Bu olay en çok neye zarar veriyor?"
            requirement="Tüm olayları doğru kutuya yerleştir"
            class="mt-6"
        >
            <x-sorter.card answer="gizlilik" label="Okunan yazışmalar">
                Biri Ayşe’nin e-posta parolasını tahmin edip hesabına girdi ve özel yazışmalarını okudu.

                <x-slot:explanation>
                    Hiçbir şey silinmedi ya da değiştirilmedi, ama özel bilgiler görmemesi gereken birinin eline geçti.
                    Bu bir <strong class="font-bold">gizlilik</strong> ihlali.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="butunluk" label="Değiştirilen notlar">
                Okulun not sistemine sızan biri, birkaç öğrencinin sınav notlarını değiştirdi.

                <x-slot:explanation>
                    Notlar hâlâ yerinde ve herkes görebiliyor, ama artık doğru değiller. Bilginin izinsiz değiştirilmesi
                    <strong class="font-bold">bütünlüğü</strong> bozar.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="erisilebilirlik" label="Kilitlenen fotoğraflar">
                Zeynep’in bilgisayarına bulaşan bir fidye yazılımı tüm fotoğraflarını kilitledi ve açmak için para istiyor.

                <x-slot:explanation>
                    Fotoğraflar hâlâ bilgisayarda ama Zeynep onlara ulaşamıyor. Bu bir <strong class="font-bold">erişilebilirlik</strong> sorunu.
                    Fotoğraflarının ayrı bir yerde yedeği olsaydı, para ödemeden hepsini geri getirebilirdi.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="gizlilik" label="Fotoğrafı çekilen ekran">
                Kafede açık bırakılan bir dizüstü bilgisayarın ekranındaki müşteri listesinin fotoğrafı çekildi.

                <x-slot:explanation>
                    Kimse bir şeyi değiştirmedi ya da silmedi, ama bilgiler yabancıların eline geçti: <strong class="font-bold">gizlilik</strong> ihlali.
                    Masadan kalkarken ekranını kilitlemek bunu önler.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="erisilebilirlik" label="Açılmayan site">
                Bir alışveriş sitesine aynı anda milyonlarca sahte istek gönderildi ve site, indirim gününde saatlerce açılmadı.

                <x-slot:explanation>
                    Siteye ulaşılamaması <strong class="font-bold">erişilebilirliği</strong> bozar.
                    Bir siteyi sahte isteklere boğarak çalışamaz hale getirmeye <em>hizmet engelleme saldırısı</em> (DoS) denir.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="butunluk" label="Değiştirilen haber">
                Bir haber sitesine sızan saldırgan, bir haberin içeriğini değiştirip yanlış bilgi yayınladı.

                <x-slot:explanation>
                    Haber herkes tarafından okunabiliyor, ama içeriği artık güvenilir değil. Bu bir <strong class="font-bold">bütünlük</strong> ihlali.
                </x-slot:explanation>
            </x-sorter.card>

            <x-slot:summary>
                Bir saldırının neye zarar verdiğini anlamak, nasıl korunacağını da gösterir: gizlilik için güçlü parolalar ve kilitli ekranlar,
                bütünlük için hesaplarının güvenliği, erişilebilirlik için de düzenli yedekler.
            </x-slot:summary>
        </x-sorter>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Saldırganlar sıradan insanları neden hedef alır?">
                <x-quiz.option>Almazlar, sadece ünlüleri ve büyük şirketleri hedef alırlar.</x-quiz.option>
                <x-quiz.option correct>Herkesin parası, hesapları ve bilgileri değerlidir; saldırıların çoğu da aynı anda binlerce kişiye yapılır.</x-quiz.option>
                <x-quiz.option>Sadece bilgisayarı eski olan kişileri hedef alırlar.</x-quiz.option>

                <x-slot:explanation>
                    Sahte mesajlar genellikle tek tek kişilere değil, binlerce kişiye aynı anda gönderilir. “Benim neyim var ki?”
                    diye düşünüp önlem almamak, saldırganın tam istediği şeydir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Dosyalarının bir kopyasını (yedeğini) ayrı bir yerde tutmak seni en çok neye karşı korur?">
                <x-quiz.option>Birinin dosyalarını okumasına karşı.</x-quiz.option>
                <x-quiz.option correct>Dosyaların kilitlenir, silinir ya da cihazın bozulursa onları kaybetmene karşı.</x-quiz.option>
                <x-quiz.option>Sahte e-postalara karşı.</x-quiz.option>

                <x-slot:explanation>
                    Yedek, <strong class="font-bold">erişilebilirliği</strong> korur. Bir fidye yazılımı dosyalarını kilitlese ya da telefonun
                    kaybolsa bile, yedeğin sayesinde dosyalarına yeniden ulaşabilirsin.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Telefonun bir güncelleme yüklemek istiyor. Ne yapmalısın?">
                <x-quiz.option>Yüklememeliyim, güncellemeler telefonu yavaşlatır.</x-quiz.option>
                <x-quiz.option>Sadece yeni bir özellik getiriyorsa yüklerim.</x-quiz.option>
                <x-quiz.option correct>Mümkün olan en kısa sürede yüklerim, çünkü güncellemeler bilinen güvenlik açıklarını kapatır.</x-quiz.option>

                <x-slot:explanation>
                    Bir güvenlik açığı keşfedildiğinde, saldırganlar onu güncellemeyi yapmamış cihazlarda denemeye başlar.
                    Güncellemeyi ertelemek, kapısı açık kalmış bir evde oturmaya benzer.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
