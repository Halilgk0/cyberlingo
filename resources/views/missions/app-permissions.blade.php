<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Telefonundaki her uygulama bir şeylere erişmek ister: kameraya, konumuna, rehberine… Bazıları gerçekten gereklidir,
        bazıları ise uygulamanın senden çok daha fazlasını toplamak istediğini gösterir. Bu görevde hangi iznin ne anlama geldiğini öğrenecek,
        sonra dört uygulamanın izinlerini kendin ayarlayacaksın.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Uygulamalar neden izin ister?">
        <div class="lesson">
            <p>
                Bir uygulamanın telefonundaki bir özelliğe ya da bilgiye erişebilmesi için senin onay vermen gerekir; buna <strong>izin</strong> denir.
                Harita uygulamasının konumuna, kamera uygulamasının kameraya ihtiyacı vardır. Ama bir el feneri uygulaması neden rehberini okumak istesin?
            </p>

            <h3>Altın soru: Buna neden ihtiyacı var?</h3>
            <p>
                Bir izin isteği gördüğünde kendine sor: <strong>Bu uygulamanın asıl işini yapması için bu izin gerekli mi?</strong>
                Gerekli değilse reddet. Uygulama yine de çalışıyorsa zaten ihtiyacı yokmuş demektir. Gereksiz izinler, kişisel bilgilerinin
                toplanıp reklamcılara satılmasına ya da daha kötüsü, zararlı bir uygulamanın seni gözetlemesine kapı açar.
            </p>

            <h3>En tehlikeli izinler</h3>
        </div>

        <ul class="mt-5 grid gap-3 sm:grid-cols-2">
            @foreach ([
                ['SMS okuma', 'Telefonuna gelen doğrulama kodlarını okuyabilir. Zararlı bir uygulama, iki adımlı doğrulamanı bu yolla aşabilir.'],
                ['Erişilebilirlik hizmeti', 'Aslında görme ya da hareket güçlüğü olan kullanıcılar için. Ekranındaki her şeyi okuyabilir ve senin yerine dokunabilir. Banka bilgilerini çalan zararlı uygulamaların en sevdiği izin.'],
                ['Bilinmeyen kaynaklardan yükleme', 'Resmi mağaza dışından uygulama kurmana izin verir. SMS ile gelen “kargo takip uygulaması” bağlantıları çoğu zaman zararlı yazılımdır.'],
                ['Rehber ve konum', 'Kişilerin ve nerede olduğun, reklamcılara ve dolandırıcılara satılabilecek değerli bilgilerdir. Sadece gerçekten gerekiyorsa ver.'],
            ] as [$permission, $danger])
                <li class="bg-card border-line rounded-2xl border p-5">
                    <p class="font-display text-xl leading-tight font-extrabold tracking-tight">{{ $permission }}</p>
                    <p class="text-muted mt-2 leading-relaxed">{{ $danger }}</p>
                </li>
            @endforeach
        </ul>

        <div class="lesson mt-8">
            <h3>Güvenli uygulama alışkanlıkları</h3>
            <ol>
                <li><strong>Sadece resmi mağazalardan indir.</strong> Google Play ve App Store’daki uygulamalar yayınlanmadan önce incelenir; internetten indirilen dosyalar incelenmez.</li>
                <li><strong>İndirmeden önce bak.</strong> Geliştiricinin adı, yorumlar ve indirme sayısı tutarlı mı? Popüler uygulamaların sahte kopyaları olur.</li>
                <li><strong>“Yalnızca uygulamayı kullanırken” seç.</strong> Konum gibi izinlerde bu seçenek varsa her zaman izin vermek yerine onu tercih et.</li>
                <li><strong>Arada bir temizlik yap.</strong> <em>Ayarlar › Uygulamalar › İzinler</em> bölümüne girip kullanmadığın uygulamaları sil, gereksiz izinleri kapat.</li>
            </ol>
        </div>

        <x-callout tone="warning" title="Dosya uzantısına dikkat" class="mt-8">
            <strong class="font-bold">fatura.pdf.exe</strong> gibi bir dosya PDF değil, bir programdır. Bilgisayarlar bilinen uzantıları gizleyebildiği için
            sen sadece “fatura.pdf” görürsün. Beklemediğin ekleri açma ve dosya gezgininin ayarlarından dosya uzantılarını görünür yap.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="İzinleri sen ayarla">
        <div class="lesson">
            <p>
                Dört uygulama kurmak üzeresin ve her biri bazı izinler istiyor. Hepsi başlangıçta kapalı. Sadece uygulamanın işi için gerçekten
                gerekenleri aç, sonra “Kaydet”e bas. Bir izni yanlış ayarlarsan nedenini görecek ve düzeltebileceksin.
            </p>
        </div>

        <x-permissions requirement="Dört uygulamanın izinlerini doğru ayarla" class="mt-6">
            <x-permissions.app name="Süper El Feneri" icon="🔦" description="Telefonunun flaşını el feneri olarak kullanır.">
                <x-permissions.item>
                    Rehber (kişiler)
                    <x-slot:reason>Bir el fenerinin kişilerine ihtiyacı yok. Bu izin, rehberini toplayıp satmak için istenmiş olabilir.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    Konum
                    <x-slot:reason>Işık yakmak için nerede olduğunu bilmesi gerekmez.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    Mikrofon
                    <x-slot:reason>Bir el fenerinin seni dinlemesi için hiçbir neden yok.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    SMS okuma
                    <x-slot:reason>SMS izni doğrulama kodlarını okumaya yarar. Bir el fenerinde bu izin büyük bir tehlike işaretidir; böyle bir uygulamayı hiç kurmamak en iyisi.</x-slot:reason>
                </x-permissions.item>
            </x-permissions.app>

            <x-permissions.app name="Yol Bul" icon="🧭" description="Gideceğin yere adım adım yol tarifi verir.">
                <x-permissions.item needed>
                    Konum
                    <x-slot:reason>Yol tarifi için nerede olduğunu bilmesi gerekir. Mümkünse “Yalnızca uygulamayı kullanırken” seçeneğini tercih et.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    Rehber (kişiler)
                    <x-slot:reason>Yol tarifi vermek için kişilerine ihtiyacı yok.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    Kamera
                    <x-slot:reason>Haritayı göstermek için kameraya gerek yok.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    SMS okuma
                    <x-slot:reason>Bir harita uygulamasının mesajlarını okumasına gerek yok.</x-slot:reason>
                </x-permissions.item>
            </x-permissions.app>

            <x-permissions.app name="Foto Stüdyo" icon="🎨" description="Fotoğraf çeker, filtre ekler ve düzenler.">
                <x-permissions.item needed>
                    Kamera
                    <x-slot:reason>Fotoğraf çekebilmesi için kameraya ihtiyacı var.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item needed>
                    Fotoğraflar ve videolar
                    <x-slot:reason>Galerindeki fotoğrafları düzenleyebilmesi için gerekli. Bazı telefonlarda sadece seçtiğin fotoğraflara izin verebilirsin; bu daha da iyi.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    Konum
                    <x-slot:reason>Fotoğraf düzenlemek için konum gerekmez. Üstelik fotoğraflarına konum eklenirse paylaştığında evinin yeri ortaya çıkabilir.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    Rehber (kişiler)
                    <x-slot:reason>Fotoğraf düzenlemenin kişilerinle hiçbir ilgisi yok.</x-slot:reason>
                </x-permissions.item>
            </x-permissions.app>

            <x-permissions.app name="Sohbet" icon="💬" description="Arkadaşlarınla yazışır, sesli mesaj ve fotoğraf gönderirsin.">
                <x-permissions.item needed>
                    Rehber (kişiler)
                    <x-slot:reason>Rehberindeki arkadaşlarını uygulamada bulabilmen için kullanılır.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item needed>
                    Mikrofon
                    <x-slot:reason>Sesli mesaj ve sesli arama için gerekli.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item needed>
                    Kamera
                    <x-slot:reason>Fotoğraf göndermek ve görüntülü arama yapmak için gerekli.</x-slot:reason>
                </x-permissions.item>
                <x-permissions.item>
                    Erişilebilirlik hizmeti
                    <x-slot:reason>Bir mesajlaşma uygulamasının ekranındaki her şeyi okumasına ve senin yerine dokunmasına gerek yok. Bu izni isteyen bir uygulamaya karşı çok dikkatli ol.</x-slot:reason>
                </x-permissions.item>
            </x-permissions.app>
        </x-permissions>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bir SMS, “Kargonuzu takip etmek için uygulamamızı yükleyin” diyor ve bir .apk dosyası indiriyor. Ne yapmalısın?">
                <x-quiz.option>Yüklerim; kargomu takip etmem gerekiyor.</x-quiz.option>
                <x-quiz.option>Yüklerim ama hiçbir izin vermem.</x-quiz.option>
                <x-quiz.option correct>Yüklemem; uygulamaları sadece resmi mağazadan indiririm ve kargomu firmanın kendi sitesinden takip ederim.</x-quiz.option>

                <x-slot:explanation>
                    SMS ile gönderilen uygulama dosyaları, bankacılık bilgilerini çalan zararlı yazılımların en yaygın yayılma yoludur.
                    Yüklemek için “bilinmeyen kaynaklar” iznini açman istenir; bu, en büyük tehlike işaretlerinden biridir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir oyun, “Erişilebilirlik hizmeti” izni istiyor. Bu izin ne yapabilir?">
                <x-quiz.option>Sadece oyundaki yazıları büyütür.</x-quiz.option>
                <x-quiz.option correct>Ekranımdaki her şeyi okuyabilir ve benim yerime dokunabilir.</x-quiz.option>
                <x-quiz.option>Hiçbir şey; zararsız bir izindir.</x-quiz.option>

                <x-slot:explanation>
                    Erişilebilirlik hizmeti çok güçlü bir izindir. Bir oyunun buna ihtiyacı yoktur; isteyen bir oyunu kaldırmak en güvenlisidir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="E-postadaki “fatura.pdf.exe” adlı ek nedir?">
                <x-quiz.option>Bir PDF faturası.</x-quiz.option>
                <x-quiz.option correct>PDF gibi görünen bir program; açılırsa bilgisayarına zararlı yazılım kurabilir.</x-quiz.option>
                <x-quiz.option>Sıkıştırılmış bir klasör.</x-quiz.option>

                <x-slot:explanation>
                    Bir dosyanın türünü son uzantısı belirler. “.exe” çalıştırılabilir bir programdır; “.pdf” kısmı sadece seni kandırmak için adın ortasına eklenmiş.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
