<x-layouts.mission :mission="$mission" :steps="['hazirlik' => 'Hazırlık', 'kusatma' => 'Kuşatma']">
    <x-slot:intro>
        Uzun bir yoldan geçtin, yolcu. Şimdi kaleni kuşatan ordunun karşısındasın: her biri farklı bir saldırı olan on iki soru.
        Her soruya tek hakkın var. En az onunu doğru bilirsen kale ayakta kalır ve Siber Şövalye Beratını alırsın.
    </x-slot:intro>

    <x-mission.step id="hazirlik" number="1" title="Kuşatmadan önce">
        <div class="lesson">
            <p>Sorular yolun bütün bölümlerinden geliyor. Son bir kez hatırla:</p>
        </div>

        <ul class="mt-6 grid gap-3 sm:grid-cols-2">
            @foreach ([
                ['Surlar', 'Uzun, tahmin edilemeyen ve her hesapta farklı parolalar; hepsini bir kasa saklar.'],
                ['Kapı', 'İki adımlı doğrulama; en güçlüsü güvenlik anahtarı ve geçiş anahtarı.'],
                ['Nöbetçiler', 'Alan adını oku, aciliyete kanma, kodu kimseyle paylaşma, kuruma kendi yolunla ulaş.'],
                ['Pazar yeri', 'Gerçek olamayacak kadar ucuz teklif, havale isteği ve kimliği belirsiz satıcı.'],
                ['Gizli geçitler', 'Paylaşımların ve uygulama izinlerin saldırgana yol gösterebilir.'],
                ['Hazine odası', 'Şifreleme bilgini okunmaz kılar; 3-2-1 yedek her felakette kurtarır.'],
                ['İşaret ateşi', 'Krizde sırayla davran: önce içeri gir ya da bul, sonra kilitle, arka kapıları kapat, en son haber ver.'],
            ] as [$layer, $reminder])
                <li class="bg-card border-line flex gap-3 rounded-2xl border-2 p-4">
                    <span class="bg-signal font-rune grid size-8 shrink-0 place-items-center rounded-full text-xs font-bold text-[#1d1408]">{{ ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII'][$loop->index] }}</span>
                    <span>
                        <span class="font-display block text-xl font-extrabold">{{ $layer }}</span>
                        <span class="text-muted block leading-relaxed">{{ $reminder }}</span>
                    </span>
                </li>
            @endforeach
        </ul>

        <x-callout tone="warning" title="Kuşatmanın kuralları" class="mt-8">
            Her soruya tek hakkın var; cevap verdikten sonra doğru seçenek yeşil olarak gösterilir. On iki sorudan en az onunu doğru bilmelisin.
            Kale düşerse sınavı baştan başlatabilirsin.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="kusatma" number="2" title="Kuşatma">
        <x-exam pass="10" requirement="Son sınavı en az 10 doğruyla geç" class="mt-2">
            <x-exam.question topic="Surlar · Parola" prompt="Bu parolalardan hangisi en güçlüsü?">
                <x-quiz.option>Galatasaray1905!</x-quiz.option>
                <x-quiz.option>P@r0la2026</x-quiz.option>
                <x-quiz.option correct>Ay-Dere-Kalem-Bulut-48</x-quiz.option>

                <x-slot:explanation>
                    Birbiriyle ilgisiz kelimelerden oluşan uzun bir parola cümlesi hem güçlü hem akılda kalıcıdır. Takım adı ve kuruluş yılı, saldırganların ilk denediklerindendir; harfleri sembolle değiştirmek de onları şaşırtmaz.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Kapı · İki adımlı doğrulama" prompt="Oltalamaya karşı da koruyan en güçlü iki adımlı doğrulama yöntemi hangisi?">
                <x-quiz.option>SMS ile gelen kod</x-quiz.option>
                <x-quiz.option correct>Güvenlik anahtarı ya da geçiş anahtarı (passkey)</x-quiz.option>
                <x-quiz.option>E-postayla gelen kod</x-quiz.option>

                <x-slot:explanation>
                    Güvenlik anahtarları ve geçiş anahtarları yalnızca gerçek sitenin adresinde çalışır; sahte bir siteye “yazdırılamazlar”.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Nöbetçiler · Bağlantılar" prompt="“https://mavibank.com.tr.oturum-ac.net/giris” adresi kime ait?">
                <x-quiz.option>mavibank.com.tr</x-quiz.option>
                <x-quiz.option correct>oturum-ac.net</x-quiz.option>
                <x-quiz.option>giris</x-quiz.option>

                <x-slot:explanation>
                    İlk eğik çizgiden önceki kısmı sağdan sola oku: alan adı oturum-ac.net. Soldaki “mavibank.com.tr.” sadece saldırganın eklediği bir alt alan adı.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Nöbetçiler · Oltalama" prompt="Bankandan geldiği söylenen bir e-posta, hesabın kapanmasın diye 24 saat içinde şifreni yenilemeni istiyor. İlk adımın ne olmalı?">
                <x-quiz.option>E-postadaki bağlantıya tıklayıp hemen şifremi yenilerim.</x-quiz.option>
                <x-quiz.option correct>Bağlantıya dokunmadan bankanın uygulamasını açar ya da adresini kendim yazarım.</x-quiz.option>
                <x-quiz.option>E-postayı yanıtlayıp doğru olup olmadığını sorarım.</x-quiz.option>

                <x-slot:explanation>
                    Aciliyet oltalamanın en bilinen işaretidir. Kuruma her zaman kendi bildiğin yoldan ulaş; gerçekten bir sorun varsa orada da görürsün.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Nöbetçiler · Dolandırıcılar" prompt="“Operatörden arıyoruz, size hediye tanımlayacağız” diyen biri, telefonuna gelen 6 haneli kodu istiyor. Ne yaparsın?">
                <x-quiz.option>Hediye için kodu söylerim.</x-quiz.option>
                <x-quiz.option>Önce adını ve sicil numarasını sorar, sonra söylerim.</x-quiz.option>
                <x-quiz.option correct>Kodu kimseyle paylaşmam ve konuşmayı bitiririm.</x-quiz.option>

                <x-slot:explanation>
                    Doğrulama kodu sadece senin içindir. Kodu isteyen herkes, kim olduğunu söylerse söylesin, dolandırıcıdır.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Pazar yeri · Sahte mağaza" prompt="Yeni açılmış bir site, bir telefonu yüzde 80 indirimle satıyor ve sadece havale kabul ediyor. Neden uzak durmalısın?">
                <x-quiz.option correct>Fiyat gerçek dışı ve havalede, kartla ödemedeki gibi bankana itiraz edip paranı geri isteyemezsin.</x-quiz.option>
                <x-quiz.option>Havale yavaş olduğu için ürün geç gelir.</x-quiz.option>
                <x-quiz.option>Uzak durmama gerek yok; indirim kampanyası olabilir.</x-quiz.option>

                <x-slot:explanation>
                    Gerçek dışı fiyat, yeni site ve havale isteği sahte mağazaların klasik üçlüsüdür. Kartla ödeme, ürün gelmezse itiraz hakkı verir.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Gizli geçitler · Paylaşımlar" prompt="Bunlardan hangisini herkese açık paylaşmak en risklisi?">
                <x-quiz.option>Okuduğun bir kitabın kapağı</x-quiz.option>
                <x-quiz.option correct>Uçuştan önce biniş kartının fotoğrafı</x-quiz.option>
                <x-quiz.option>Bir gün batımı fotoğrafı</x-quiz.option>

                <x-slot:explanation>
                    Biniş kartındaki barkod adını ve rezervasyon kodunu verir; biri uçuşunu değiştirebilir. Üstelik evinin boş olduğunu da duyurur.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Gizli geçitler · Uygulama izinleri" prompt="Bir el feneri uygulaması SMS okuma izni istiyor. Ne yapmalısın?">
                <x-quiz.option>İzin veririm; çalışması için gerekiyordur.</x-quiz.option>
                <x-quiz.option correct>Reddederim; böyle bir izin isteyen bir el fenerini hiç kurmamak en iyisi.</x-quiz.option>
                <x-quiz.option>Sadece bir kez izin veririm.</x-quiz.option>

                <x-slot:explanation>
                    SMS izni doğrulama kodlarını okumaya yarar. Uygulamanın işiyle ilgisi olmayan bir izin, büyük bir tehlike işaretidir.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Hazine odası · Şifreleme" prompt="Kafenin Wi-Fi’ında https kullanan bir siteye girdin. Aynı ağdaki bir saldırgan ne görebilir?">
                <x-quiz.option>Yazdığın her şeyi, parolan dahil.</x-quiz.option>
                <x-quiz.option correct>Hangi siteye bağlandığını, ama ne yazdığını değil.</x-quiz.option>
                <x-quiz.option>Hiçbir şeyi, bağlandığın siteyi bile.</x-quiz.option>

                <x-slot:explanation>
                    HTTPS içeriği şifreler, ama bağlanılan alan adı görünür kalır. Bunu da gizlemek istersen güvenilir bir VPN kullanabilirsin.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="Hazine odası · Yedekler" prompt="Hangisi 3-2-1 kuralına uyan bir yedek planı?">
                <x-quiz.option>Bilgisayardaki dosyalar ve aynı bilgisayarda ikinci bir klasör.</x-quiz.option>
                <x-quiz.option>Bilgisayardaki dosyalar ve hep takılı bir harici disk.</x-quiz.option>
                <x-quiz.option correct>Bilgisayardaki dosyalar, yedekten sonra çıkarılan bir harici disk ve eski sürümleri saklayan bir bulut yedeklemesi.</x-quiz.option>

                <x-slot:explanation>
                    Üç kopya, iki farklı ortam (disk ve bulut) ve biri evin dışında. Çıkarılan disk fidye yazılımından, bulut da yangından ve hırsızlıktan korur.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="İşaret ateşi · Sızıntı" prompt="Bir sızıntı raporunda yalnızca adının, telefonunun ve adresinin sızdığını gördün. Ne yapmalısın?">
                <x-quiz.option>Hemen bütün parolalarımı değiştiririm; başka bir şey gerekmez.</x-quiz.option>
                <x-quiz.option correct>Tetikte olurum: bu bilgileri bilen mesajlar ve aramalar gerçek olduklarını kanıtlamaz.</x-quiz.option>
                <x-quiz.option>Hiçbir şey; parola sızmadıysa tehlike yoktur.</x-quiz.option>

                <x-slot:explanation>
                    Kişisel bilgiler değiştirilemez ama hedefli oltalamayı çok inandırıcı kılar. “Adresinize kargonuz gelemedi” diyen ve adını bilen bir mesaj, yine de bir tuzak olabilir.
                </x-slot:explanation>
            </x-exam.question>

            <x-exam.question topic="İşaret ateşi · Ele geçirilen hesap" prompt="Ele geçirilen e-posta hesabını geri aldın ve parolanı değiştirdin. Saldırganı tamamen dışarıda bırakmak için hangisi de gerekli?">
                <x-quiz.option>Hesabın adını değiştirmek.</x-quiz.option>
                <x-quiz.option>Eski e-postaların hepsini silmek.</x-quiz.option>
                <x-quiz.option correct>Açık oturumlardan çıkış yapmak, yönlendirme kurallarını ve bağlı uygulamaları temizlemek.</x-quiz.option>

                <x-slot:explanation>
                    Saldırganlar içerideyken arka kapı bırakır. Açık bir oturum ya da gizli bir yönlendirme kuralı, yeni parolana rağmen onu içeride tutar.
                </x-slot:explanation>
            </x-exam.question>
        </x-exam>
    </x-mission.step>
</x-layouts.mission>
