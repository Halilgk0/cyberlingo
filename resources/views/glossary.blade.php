@use('App\Enums\Mission')

@php
    /**
     * Every term the missions teach, in Turkish alphabetical order, with the mission that explains it.
     *
     * @var list<array{term: string, english: ?string, definition: string, mission: Mission}> $terms
     */
    $terms = [
        ['term' => '3D Secure', 'english' => null, 'definition' => 'Kartla internet alışverişinde bankanın, telefonuna gönderdiği kodla ödemeyi gerçekten senin yaptığını doğruladığı adım. SMS’teki tutarı ve mağaza adını mutlaka kontrol et.', 'mission' => Mission::FakeShop],
        ['term' => 'Alan adı', 'english' => 'domain', 'definition' => 'Bir internet adresinin sahibini gösteren kısmı, örneğin mavibank.com.tr. Bir bağlantının nereye gittiğini anlamak için bakman gereken yer.', 'mission' => Mission::ReadingLinks],
        ['term' => 'Alt alan adı', 'english' => 'subdomain', 'definition' => 'Alan adının soluna eklenen kısım, örneğin www. ya da destek. Alan adının sahibi istediği gibi seçer; saldırganlar gerçek kurum adlarını buraya yazar.', 'mission' => Mission::ReadingLinks],
        ['term' => 'Ana parola', 'english' => 'master password', 'definition' => 'Parola kasasını açan tek anahtar. Uzun, eşsiz bir parola cümlesi olmalı ve başka hiçbir yerde kullanılmamalı.', 'mission' => Mission::PasswordVault],
        ['term' => 'Anahtar', 'english' => 'key', 'definition' => 'Şifrelenmiş bir bilgiyi açmaya yarayan gizli değer. Modern şifrelemenin bütün gücü anahtarın gizli kalmasından gelir.', 'mission' => Mission::Encryption],
        ['term' => 'Beyaz şapkalı hacker', 'english' => 'white hat', 'definition' => 'Sistemlerin sahibinden yazılı izin alarak, belirlenen kapsamda açık arayan ve bulduklarını yalnızca sahibine bildiren güvenlik uzmanı.', 'mission' => Mission::EthicalHacking],
        ['term' => 'Botnet', 'english' => null, 'definition' => 'Saldırganın uzaktan yönettiği, zararlı yazılım bulaşmış cihazlardan oluşan ağ. Bu “zombi ordu” başka sitelere saldırmak ya da istenmeyen e-posta göndermek için kullanılır.', 'mission' => Mission::Malware],
        ['term' => 'Bulut yedekleme', 'english' => 'cloud backup', 'definition' => 'Dosyalarının kopyalarının internetteki bir hizmette saklanması. Eski sürümleri tutan bir hizmet, fidye yazılımına karşı da korur.', 'mission' => Mission::Backups],
        ['term' => 'Bütünlük', 'english' => 'integrity', 'definition' => 'Bilginin izinsiz değiştirilmemesi. Notların, haberlerin ya da bir faturadaki IBAN’ın gizlice değiştirilmesi bütünlüğü bozar.', 'mission' => Mission::SecurityBasics],
        ['term' => 'Casus yazılım', 'english' => 'spyware', 'definition' => 'Sessizce seni izleyen zararlı yazılım: yazdıklarını, gezdiğin siteleri, hatta kameranı ve mikrofonunu.', 'mission' => Mission::Malware],
        ['term' => 'CEO dolandırıcılığı', 'english' => 'business email compromise', 'definition' => 'Bir yönetici ya da tanıdık gibi davranıp acele ve gizlilik isteyerek para transferi yaptırma. Talebi her zaman bildiğin bir numaradan arayarak doğrula.', 'mission' => Mission::PhishingDragon],
        ['term' => 'CTF', 'english' => 'capture the flag', 'definition' => 'Bilerek açıklı bırakılmış sistemlerde gizli “bayrakları” bulmaya dayanan güvenlik yarışması. Etik hack pratiği yapmanın yasal yollarından biri.', 'mission' => Mission::EthicalHacking],
        ['term' => 'Çıktı kaçışlama', 'english' => 'output escaping', 'definition' => 'Sayfaya yazılan metindeki özel karakterleri zararsız hâle getirmek. Kullanıcıların yazdıklarının başka ziyaretçilerin tarayıcısında kod gibi çalışmasını (XSS) önler.', 'mission' => Mission::SecureCode],
        ['term' => 'Derinlemesine savunma', 'english' => 'defense in depth', 'definition' => 'Tek bir önleme güvenmek yerine birbirini tamamlayan katmanlar kurmak; bir katman düşünce arkasındaki yakalar. Kale surları gibi.', 'mission' => Mission::CastleDefense],
        ['term' => 'Dijital ayak izi', 'english' => 'digital footprint', 'definition' => 'İnternette bıraktığın tüm izler: paylaşımların, yorumların, fotoğrafların. Sildiğin şeyler bile başkalarının elinde kalmış olabilir.', 'mission' => Mission::Oversharing],
        ['term' => 'Doğrulama kodu', 'english' => 'one-time code', 'definition' => 'Girişte ya da bir işlemi onaylarken SMS veya uygulama ile gelen tek kullanımlık kod. Kimseyle paylaşılmaz; isteyen herkes dolandırıcıdır.', 'mission' => Mission::ScamMessages],
        ['term' => 'Erişilebilirlik', 'english' => 'availability', 'definition' => 'İhtiyacın olduğunda bilgine ve hizmetlere ulaşabilmen. Fidye yazılımları ve hizmet engelleme saldırıları erişilebilirliği bozar.', 'mission' => Mission::SecurityBasics],
        ['term' => 'Erişilebilirlik hizmeti', 'english' => 'accessibility service', 'definition' => 'Bir uygulamanın ekranındaki her şeyi okumasına ve senin yerine dokunmasına izin veren güçlü bir telefon izni. Zararlı uygulamaların en sevdiği izindir.', 'mission' => Mission::AppPermissions],
        ['term' => 'ETBİS', 'english' => null, 'definition' => 'Ticaret Bakanlığı’nın Elektronik Ticaret Bilgi Sistemi. Türkiye’de internetten satış yapan işletmeler buraya kayıt olmalı; kayıt bilgisi genellikle sitenin alt kısmında yer alır.', 'mission' => Mission::FakeShop],
        ['term' => 'Fidye yazılımı', 'english' => 'ransomware', 'definition' => 'Dosyalarını şifreleyip anahtarı vermek için para isteyen zararlı yazılım. En iyi korunma, güncel ve bilgisayardan ayrı tutulan bir yedektir.', 'mission' => Mission::Backups],
        ['term' => 'Geçiş anahtarı', 'english' => 'passkey', 'definition' => 'Parola yerine telefonunla ya da parmak izinle giriş yapmanı sağlayan yöntem. Sadece gerçek sitede çalıştığı için oltalamaya karşı da korur.', 'mission' => Mission::TwoFactor],
        ['term' => 'Gizlilik', 'english' => 'confidentiality', 'definition' => 'Bilginin sadece görmesi gereken kişilerce görülebilmesi. Mesajlarının bir yabancı tarafından okunması gizliliği bozar.', 'mission' => Mission::SecurityBasics],
        ['term' => 'Gri şapkalı hacker', 'english' => 'grey hat', 'definition' => 'Çoğu zaman iyi niyetli olsa da sistemleri izin almadan deneyen kişi. Bulduğunu haber verse bile izinsiz girdiği için yaptığı suç sayılabilir.', 'mission' => Mission::EthicalHacking],
        ['term' => 'Güncelleme', 'english' => 'update, patch', 'definition' => 'Yazılımdaki hataları ve güvenlik açıklarını kapatan düzeltme. Telefonun ya da bilgisayarın güncelleme isterse erteleme.', 'mission' => Mission::SecurityBasics],
        ['term' => 'Güvenlik açığı', 'english' => 'vulnerability', 'definition' => 'Bir yazılımdaki, saldırganların izinsiz erişim için kullanabileceği hata. Güncellemeler bu açıkları kapatır.', 'mission' => Mission::Malware],
        ['term' => 'Halka açık Wi-Fi', 'english' => 'public Wi-Fi', 'definition' => 'Kafe, havalimanı, otel gibi yerlerde herkesin bağlanabildiği kablosuz ağ. Aynı ağdaki herkesle aynı yolu paylaştığın için önemli işleri mobil veriyle yapmak daha güvenlidir.', 'mission' => Mission::PublicWifi],
        ['term' => 'Hash', 'english' => 'karıştırılmış parola', 'definition' => 'Parolanın geri çevrilemeyen bir matematik işlemiyle karıştırılmış hali. Siteler parolaları böyle saklar; ama zayıf parolalar tahminle kısa sürede bulunur.', 'mission' => Mission::DataBreach],
        ['term' => 'Hata ödül programı', 'english' => 'bug bounty', 'definition' => 'Şirketlerin, kurallarına ve kapsamına uyarak açık bulup bildirenlere ödül verdiği program. Kapsam dışındaki denemeler yine izinsiz sayılır.', 'mission' => Mission::ResponsibleDisclosure],
        ['term' => 'Hedefli oltalama', 'english' => 'spear phishing', 'definition' => 'Senin hakkında toplanan bilgilerle (okulun, işin, arkadaşların) sana özel hazırlanmış, bu yüzden çok daha inandırıcı olan oltalama mesajı.', 'mission' => Mission::Oversharing],
        ['term' => 'Hizmet engelleme saldırısı', 'english' => 'DoS', 'definition' => 'Bir siteyi sahte isteklere boğarak kullanılamaz hale getirme saldırısı.', 'mission' => Mission::SecurityBasics],
        ['term' => 'Homoglif saldırısı', 'english' => 'homograph attack', 'definition' => 'Başka alfabelerden birebir aynı görünen harflerle sahte alan adı kurmak (Kiril “а” ile Latin “a” gibi). Tarayıcılar bu adresleri “xn--” ile başlayan halleriyle gösterir.', 'mission' => Mission::PhishingDragon],
        ['term' => 'HTTPS', 'english' => null, 'definition' => 'Tarayıcınla site arasındaki bağlantıyı şifreleyen yöntem. Adres çubuğundaki kilit simgesi, sitenin güvenilir olduğunu değil, bağlantının şifreli olduğunu söyler.', 'mission' => Mission::PublicWifi],
        ['term' => 'IMEI', 'english' => null, 'definition' => 'Her telefonun 15 haneli kimlik numarası. *#06# tuşlayarak görebilirsin. Kayıp ya da çalıntı bildiriminde telefonun bu numarayla şebekeye kapatılır.', 'mission' => Mission::LostPhone],
        ['term' => 'İki adımlı doğrulama', 'english' => '2FA', 'definition' => 'Girişte parolana ek olarak telefonuna gelen kod gibi ikinci bir kanıt isteyen koruma. Parolan çalınsa bile hesabını korur.', 'mission' => Mission::TwoFactor],
        ['term' => 'İzin', 'english' => 'permission', 'definition' => 'Bir uygulamanın kamera, konum, rehber gibi telefon özelliklerine erişebilmesi için verdiğin onay.', 'mission' => Mission::AppPermissions],
        ['term' => 'Kaba kuvvet saldırısı', 'english' => 'brute force', 'definition' => 'Bütün olasılıkları tek tek deneyerek bir parolayı ya da şifreyi kırma yöntemi. Uzun parolalar ve büyük anahtarlar buna karşı korur.', 'mission' => Mission::StrongPassword],
        ['term' => 'Kayıp modu', 'english' => 'lost mode', 'definition' => 'Kaybolan bir telefonu uzaktan kilitleyip ekranına sana ulaşılabilecek bir mesaj yazdıran özellik.', 'mission' => Mission::LostPhone],
        ['term' => 'Kimlik bilgisi doldurma', 'english' => 'credential stuffing', 'definition' => 'Bir sızıntıda ele geçen kullanıcı adı ve parolaların başka sitelerde otomatik olarak denenmesi. Her hesapta farklı parola kullanmak korur.', 'mission' => Mission::DataBreach],
        ['term' => 'Kötü ikiz', 'english' => 'evil twin', 'definition' => 'Saldırganın gerçek bir Wi-Fi ağına benzeyen isimle kurduğu sahte ağ. Bağlananların trafiği saldırganın cihazından geçer.', 'mission' => Mission::PublicWifi],
        ['term' => 'Oltalama', 'english' => 'phishing', 'definition' => 'Güvendiğin bir kurum ya da kişi gibi görünerek seni bir bağlantıya tıklamaya veya bilgilerini vermeye kandıran sahte mesaj ya da site.', 'mission' => Mission::PhishingEmail],
        ['term' => 'Oturum', 'english' => 'session', 'definition' => 'Bir hesaba giriş yaptığın her cihazda açık kalan bağlantı. Ele geçirilen bir hesapta “tüm cihazlardan çıkış yap” ile saldırganın oturumunu kapatırsın.', 'mission' => Mission::AccountRecovery],
        ['term' => 'Parametreli sorgu', 'english' => 'prepared statement', 'definition' => 'Veritabanına komutu ve kullanıcıdan gelen veriyi ayrı ayrı gönderme yöntemi. Veri asla komut gibi çalışmaz; SQL enjeksiyonuna karşı temel önlemdir.', 'mission' => Mission::SecureCode],
        ['term' => 'Parola yöneticisi', 'english' => 'password manager', 'definition' => 'Tüm parolalarını şifreli olarak saklayan ve senin için güçlü parolalar üreten uygulama. Sadece tek bir ana parolayı hatırlaman yeter.', 'mission' => Mission::PasswordVault],
        ['term' => 'Security.txt', 'english' => null, 'definition' => 'Sitelerin /.well-known/security.txt adresine koyduğu, güvenlik açığı bildirmek isteyenlerin kime ve nasıl ulaşacağını yazan standart dosya.', 'mission' => Mission::ResponsibleDisclosure],
        ['term' => 'Sızıntı', 'english' => 'data breach', 'definition' => 'Bir kurumun sakladığı bilgilerin (e-postalar, parolalar, adresler) saldırganların eline geçmesi.', 'mission' => Mission::DataBreach],
        ['term' => 'Sızma testi', 'english' => 'penetration test', 'definition' => 'Bir kurumun izniyle ve belirlenen kapsamda, gerçek bir saldırganın yapabileceklerini deneyen güvenlik testi. Sonunda bulguları anlatan bir rapor yazılır.', 'mission' => Mission::EthicalHacking],
        ['term' => 'Siyah şapkalı hacker', 'english' => 'black hat', 'definition' => 'Zarar vermek ya da kazanç sağlamak için sistemlere izinsiz giren kişi: veri çalar, satar, şantaj yapar.', 'mission' => Mission::EthicalHacking],
        ['term' => 'Solucan', 'english' => 'worm', 'definition' => 'Kimse bir şeye tıklamadan ağ üzerinden kendi kendine yayılan zararlı yazılım. Güncellenmemiş sistemlerdeki açıkları kullanır.', 'mission' => Mission::Malware],
        ['term' => 'Sorumlu bildirim', 'english' => 'responsible disclosure', 'definition' => 'Bir güvenlik açığını önce yalnızca sistemin sahibine bildirmek, düzeltmesi için zaman tanımak ve ancak açık kapandıktan sonra konuşmak.', 'mission' => Mission::ResponsibleDisclosure],
        ['term' => 'Sosyal mühendislik', 'english' => 'social engineering', 'definition' => 'Bilgisayarı değil insanı kandırarak bilgi, para ya da erişim elde etme. Korku, aciliyet ve güven duygularını kullanır.', 'mission' => Mission::ScamMessages],
        ['term' => 'Sözlük saldırısı', 'english' => 'dictionary attack', 'definition' => 'Sık kullanılan parolaların ve kelimelerin listesini sırayla deneyerek parola tahmin etme.', 'mission' => Mission::StrongPassword],
        ['term' => 'SQL enjeksiyonu', 'english' => 'SQL injection', 'definition' => 'Kullanıcının yazdığı metnin bir veritabanı sorgusuna yapıştırılıp komutun parçası gibi yorumlanmasıyla oluşan açık. Parametreli sorguyla önlenir.', 'mission' => Mission::SecureCode],
        ['term' => 'Şantaj e-postası', 'english' => 'extortion scam', 'definition' => 'Eski bir sızıntıdan bulunan parolanı yazıp “bilgisayarına girdim, seni kaydettim” diyerek para isteyen e-posta. Neredeyse her zaman yalandır; para gönderme, yanıt verme.', 'mission' => Mission::DataBreach],
        ['term' => 'Şifreleme', 'english' => 'encryption', 'definition' => 'Bir bilgiyi anahtarı olmayanların okuyamayacağı hale getirme. HTTPS, uçtan uca şifreleme ve telefon kilidi bunu kullanır.', 'mission' => Mission::Encryption],
        ['term' => 'Truva atı', 'english' => 'trojan', 'definition' => 'Faydalı bir program gibi görünüp kurulunca arkasından zararlı işler yapan yazılım. Korsan oyunlar ve sahte güncellemeler en sevdiği kılıklardır.', 'mission' => Mission::Malware],
        ['term' => 'Tuş kaydedici', 'english' => 'keylogger', 'definition' => 'Klavyede yazdığın her şeyi, parolaların dahil, kaydedip saldırgana gönderen casus yazılım.', 'mission' => Mission::Malware],
        ['term' => 'Uçtan uca şifreleme', 'english' => 'end-to-end encryption', 'definition' => 'Mesajın gönderenin cihazında şifrelenip sadece alıcının cihazında çözülmesi. Aradaki sunucu bile mesajı okuyamaz.', 'mission' => Mission::Encryption],
        ['term' => 'URL', 'english' => null, 'definition' => 'Bir web sayfasının tam adresi, örneğin https://www.mavibank.com.tr/giris. Protokol, alan adı ve yol gibi parçalardan oluşur.', 'mission' => Mission::ReadingLinks],
        ['term' => 'Uzaktan silme', 'english' => 'remote wipe', 'definition' => 'Kaybolan ya da çalınan bir cihazdaki bütün bilgileri internet üzerinden silme. Bazı telefonlarda sildikten sonra konum görülemez; önce bulmayı dene.', 'mission' => Mission::LostPhone],
        ['term' => 'VPN', 'english' => null, 'definition' => 'Cihazının trafiğini şifreli bir tünelle başka bir sunucuya taşıyan hizmet. Aynı ağdaki kişilerden gizler, ama trafiğin VPN şirketinden geçer.', 'mission' => Mission::PublicWifi],
        ['term' => 'XSS', 'english' => 'cross-site scripting', 'definition' => 'Bir sitenin, kullanıcıların yazdıklarını kaçışlamadan göstermesiyle başka ziyaretçilerin tarayıcısında kod çalıştırılabilmesi. Çıktı kaçışlamayla önlenir.', 'mission' => Mission::SecureCode],
        ['term' => 'Yedek', 'english' => 'backup', 'definition' => 'Dosyalarının ayrı bir yerde tutulan kopyası. 3-2-1 kuralı: 3 kopya, 2 farklı ortam, 1 kopya evin dışında.', 'mission' => Mission::Backups],
        ['term' => 'Yetkilendirme', 'english' => 'authorization', 'definition' => 'Giriş yapmış birinin istediği şeye erişme izni olup olmadığını denetlemek. Kimlik doğrulama “Sen kimsin?”, yetkilendirme “Buna iznin var mı?” sorusunu yanıtlar.', 'mission' => Mission::SecureCode],
        ['term' => 'Yönlendirme kuralı', 'english' => 'forwarding rule', 'definition' => 'Gelen e-postaları otomatik olarak başka bir adrese gönderen ayar. Hesabı ele geçiren saldırganlar gizlice ekler; parolan değişse bile e-postalarını okumaya devam ederler.', 'mission' => Mission::AccountRecovery],
        ['term' => 'Zararlı yazılım', 'english' => 'malware', 'definition' => 'Cihazına zarar vermek, bilgilerini çalmak ya da seni gözetlemek için yazılmış program. Virüsler, casus yazılımlar ve fidye yazılımları bu gruptadır.', 'mission' => Mission::Malware],
    ];
@endphp

<x-layouts.app title="Sözlük">
    <section class="pt-10 pb-12 sm:pt-16">
        <h1 class="font-display text-4xl leading-[0.95] font-extrabold tracking-tight sm:text-7xl">Sözlük</h1>
        <p class="text-muted mt-6 max-w-[56ch] text-lg leading-relaxed">
            Görevlerde geçen terimlerin kısa ve anlaşılır açıklamaları. Her terimin altında, onu ayrıntısıyla anlatan görev var.
        </p>

        <label for="glossary-search" class="mt-8 block font-bold">Terim ara</label>
        <input
            id="glossary-search"
            data-glossary-search
            type="search"
            autocomplete="off"
            placeholder="Örneğin “şifre” ya da “wifi”"
            class="border-line bg-card focus:border-ink placeholder:text-muted/70 mt-2 w-full max-w-md rounded-xl border-2 px-4 py-3 text-lg focus:outline-none"
        >
        <p data-glossary-count aria-live="polite" class="text-muted mt-2">{{ count($terms) }} terim</p>
    </section>

    <div class="flex flex-col gap-12">
        @foreach (collect($terms)->groupBy(fn (array $term) => mb_substr($term['term'], 0, 1)) as $letter => $letterTerms)
            <section data-glossary-group aria-label="{{ $letter }} harfi">
                <h2 aria-hidden="true" class="font-display border-line border-b pb-2 text-3xl font-extrabold sm:text-4xl">{{ $letter }}</h2>
                <dl class="mt-5 grid gap-3 md:grid-cols-2">
                    @foreach ($letterTerms as $term)
                        <div data-glossary-term class="bg-card border-line flex flex-col rounded-2xl border p-5">
                            <dt data-glossary-searchable class="font-display text-xl leading-tight font-extrabold tracking-tight">
                                {{ $term['term'] }}
                                @if ($term['english'])
                                    <span class="text-muted font-sans text-base font-normal">({{ $term['english'] }})</span>
                                @endif
                            </dt>
                            <dd data-glossary-searchable class="text-muted mt-1.5 grow leading-relaxed">{{ $term['definition'] }}</dd>
                            <dd class="mt-3">
                                <a href="{{ route('missions.show', $term['mission']) }}" class="focus-visible:outline-ink rounded-sm font-bold underline decoration-2 underline-offset-4 focus-visible:outline-2 focus-visible:outline-offset-2">
                                    Görev {{ $term['mission']->number() }}: {{ $term['mission']->title() }}
                                </a>
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </section>
        @endforeach

        <p data-glossary-empty class="text-muted text-lg" hidden>Bu aramayla eşleşen bir terim yok. Başka bir kelime dene.</p>
    </div>
</x-layouts.app>
