@php
    /* The whole branching scenario. incident.js runs it; nothing here is sent anywhere. */
    $scenario = [
        'start' => 's1',
        'resolve' => ['at' => 'resolve', 'failFlag' => 'paid', 'goodScore' => 6, 'good' => 'son_iyi', 'ok' => 'son_orta', 'fail' => 'son_kotu'],
        'status' => [
            'yayilma' => ['label' => 'Yayılma', 'value' => 'belirsiz', 'tone' => 'neutral'],
            'kanit' => ['label' => 'Kanıt', 'value' => 'bütün', 'tone' => 'neutral'],
            'yedek' => ['label' => 'Yedek', 'value' => 'bilinmiyor', 'tone' => 'neutral'],
        ],
        'scenes' => [
            's1' => [
                'time' => '08:42',
                'speaker' => 'Selin · Muhasebe',
                'text' => 'Alo?! Bilgisayarımdaki bütün dosyaların adı değişti, hiçbiri açılmıyor. Ekranda kırmızı bir yazı: “Dosyalarınız şifrelendi. 48 saat içinde ödeyin.” Ne yapayım?',
                'choices' => [
                    [
                        'label' => '“Sakin ol. Hemen bilgisayarını ağdan çıkar: kablosunu çek, Wi-Fi’ı kapat. Ama kapatma, olduğu gibi bırak.”',
                        'to' => 's2', 'tone' => 'good', 'score' => 1, 'flags' => ['isolated'],
                        'status' => ['yayilma' => ['value' => 'durduruldu', 'tone' => 'good'], 'kanit' => ['value' => 'korunuyor', 'tone' => 'good']],
                        'feedback' => 'Doğru ilk hamle. Ağdan ayırmak zararlı yazılımın komşu bilgisayarlara yayılmasını durdurur; makineyi kapatmamak ise incelemek için gereken izleri korur.',
                    ],
                    [
                        'label' => '“Panik yapma, bilgisayarı kapatıp yeniden başlat, düzelir.”',
                        'to' => 's1b', 'tone' => 'bad', 'score' => 0,
                        'status' => ['kanit' => ['value' => 'eksik', 'tone' => 'bad']],
                        'feedback' => 'Yeniden başlatmak şifrelemeyi çoğu zaman durdurmaz, bellekteki değerli izleri siler ve makine hâlâ ağa bağlı kalır.',
                    ],
                    [
                        'label' => '“Faturalar yetişsin, sen çalışmaya devam et, ben sonra bakarım.”',
                        'to' => 's1b', 'tone' => 'bad', 'score' => -1, 'flags' => ['yayildi'],
                        'status' => ['yayilma' => ['value' => 'yayılıyor', 'tone' => 'bad']],
                        'feedback' => 'Makine ağda kaldıkça zararlı yazılım ortak klasöre ve diğer bilgisayarlara yayılmaya devam eder. Burada dakikalar önemli.',
                    ],
                ],
            ],
            's1b' => [
                'time' => '09:05',
                'text' => 'Yarım saat içinde iki departman daha aynı kırmızı ekranı bildirdi; zararlı yazılım ortak dosya sunucusuna da ulaştı. Şimdi ne yaparsın?',
                'choices' => [
                    [
                        'label' => 'Her şeyi durdur: etkilenen bütün makineleri ve dosya sunucusunu ağdan izole et.',
                        'to' => 's2', 'tone' => 'good', 'score' => 1, 'flags' => ['isolated'],
                        'status' => ['yayilma' => ['value' => 'kontrol altında', 'tone' => 'neutral']],
                        'feedback' => 'Geç kalmış olsan da yayılmayı durdurmak her şeyden önce gelir. Kanama durmadan tedaviye başlanmaz.',
                    ],
                    [
                        'label' => 'Bilgi işlem firmasını arayıp onlar gelene kadar hiçbir şeye dokunmadan bekleyelim.',
                        'to' => 's2', 'tone' => 'bad', 'score' => -1,
                        'feedback' => 'Yardım istemek doğru, ama beklerken yayılma sürmemeli. Önce kendi elinle ağ bağlantılarını kes, sonra uzmanı ara.',
                    ],
                ],
            ],
            's2' => [
                'time' => '09:20',
                'text' => 'Yayılma durdu. Artık ne olduğunu anlaman gerekiyor. İlk işin ne?',
                'choices' => [
                    [
                        'label' => 'Etkilenen sistemleri incele: hangi dosyalar şifreli, nereden girilmiş? Fidye notunu ve kayıtları kanıt olarak sakla.',
                        'to' => 's3', 'tone' => 'good', 'score' => 1, 'flags' => ['evidence'],
                        'status' => ['kanit' => ['value' => 'toplandı', 'tone' => 'good']],
                        'feedback' => 'Kanıt toplamak hem saldırının nasıl girdiğini anlamanı hem de olayı yetkililere bildirmeni sağlar.',
                    ],
                    [
                        'label' => 'Zaman kaybetme, etkilenen bütün makineleri hemen formatla, temiz başla.',
                        'to' => 's3', 'tone' => 'bad', 'score' => -1, 'flags' => ['wiped'],
                        'status' => ['kanit' => ['value' => 'silindi', 'tone' => 'bad']],
                        'feedback' => 'Formatlamak kanıtı yok eder. Nasıl girdiklerini öğrenemezsen aynı kapıdan tekrar girerler; hangi verinin gittiğini de bilemezsin.',
                    ],
                ],
            ],
            's3' => [
                'time' => '09:40',
                'speaker' => 'Genel Müdür',
                'text' => '“Ne oluyor orada? Müşteriler bekliyor, bana hemen bir şey söyle!” Nasıl yanıt verirsin?',
                'choices' => [
                    [
                        'label' => 'Durumu net anlatırım: bir fidye yazılımı, yayılmayı durdurdum, kimse ödeme yapmasın ve dışarı bilgi vermesin, planım şu...',
                        'to' => 's4', 'tone' => 'good', 'score' => 1, 'flags' => ['informed'],
                        'feedback' => 'Şeffaflık ve tek bir plan paniği önler. Herkesin kafasına göre hareket etmesini, özellikle de birinin gizlice fidyeyi ödemesini engeller.',
                    ],
                    [
                        'label' => '“Önemli bir şey yok, hallediyorum” derim; patron paniklemesin.',
                        'to' => 's4', 'tone' => 'bad', 'score' => -1,
                        'feedback' => 'Yöneticiyi karanlıkta bırakmak tehlikeli. Durumun ciddiyetini bilmezse, arkandan panikle fidyeyi ödemeye kalkabilir.',
                    ],
                    [
                        'label' => '“Birileri bilmeden zararlı bir eke tıklamış, benim suçum değil” derim.',
                        'to' => 's4', 'tone' => 'bad', 'score' => -1,
                        'feedback' => 'Şu an gereken suçlu değil, plan. Suçu birine yıkmak krizi çözmez ve ekibi savunmaya iter.',
                    ],
                ],
            ],
            's4' => [
                'time' => '10:15',
                'text' => 'Fidye notu açık: “48 saat içinde ödeyin, yoksa dosyalar sonsuza dek silinir.” Genel müdür sana dönüyor: “Ödesek mi? En hızlısı bu değil mi?”',
                'choices' => [
                    [
                        'label' => '“Ödememeliyiz. Ödemek parayı kaybetmek demek, anahtarın geleceği garanti değil ve bizi tekrar hedef yapar. Önce yedeklerimize bakalım.”',
                        'to' => 's5', 'tone' => 'good', 'score' => 1, 'flags' => ['didntPay'],
                        'feedback' => 'Ödeme ne çözümü garanti eder ne de suçluları durdurur; çoğu zaman bir sonraki saldırının davetiyesidir. Doğru yol yedekten dönmektir.',
                    ],
                    [
                        'label' => '“Ödeyelim, iş durmasın.”',
                        'to' => 's4pay', 'tone' => 'bad', 'score' => -2, 'flags' => ['paid'],
                        'feedback' => 'Karar verildi: ödeme yapılıyor. Bakalım bu nasıl sonuçlanacak...',
                    ],
                    [
                        'label' => '“Pazarlık edip yarısını ödeyelim.”',
                        'to' => 's4pay', 'tone' => 'bad', 'score' => -1, 'flags' => ['paid'],
                        'feedback' => 'Pazarlık da bir ödemedir ve saldırganla masaya oturmak demektir. Bakalım nasıl sonuçlanacak...',
                    ],
                ],
            ],
            's4pay' => [
                'time' => '2 gün sonra',
                'text' => 'Kripto parayla ödeme yapıldı ve iki gün beklendi. Gönderilen “çözücü” dosyaların yalnızca bir kısmını açtı; gerisi hâlâ kilitli ve para geri gelmeyecek. Yine de olayı doğru kapatmak için devam et.',
                'choices' => [
                    [
                        'label' => 'Yine de yedeklerimize bakalım ve işi doğru bitirelim.',
                        'to' => 's5', 'tone' => 'neutral', 'score' => 0,
                        'feedback' => 'Ödeme çoğu zaman tam da böyle biter: para gider, dosyaların hepsi geri gelmez. Asıl çözüm baştan beri yedekti.',
                    ],
                ],
            ],
            's5' => [
                'time' => '10:45',
                'text' => 'Yedekleri kontrol ettin: en son yedek dün gece alınmış ve ağdan ayrı, çevrimdışı bir diskte duruyor — şifrelemeden etkilenmemiş. Nasıl geri dönersin?',
                'choices' => [
                    [
                        'label' => 'Önce nasıl girdiklerini bulup o kapıyı kapatırım, sonra temizlenmiş sistemlere yedekten dönerim.',
                        'to' => 's6', 'tone' => 'good', 'score' => 1, 'flags' => ['restored'],
                        'status' => ['yedek' => ['value' => 'güvenli', 'tone' => 'good']],
                        'feedback' => 'Açık kapanmadan yedeği geri yüklersen aynı zararlı yazılım seni tekrar vurur. Önce kapı, sonra kurtarma.',
                    ],
                    [
                        'label' => 'Yedeği hemen, hâlâ temizlenmemiş ağa geri yüklerim; iş bir an önce dönsün.',
                        'to' => 's6', 'tone' => 'bad', 'score' => -1, 'flags' => ['reinfect'],
                        'status' => ['yedek' => ['value' => 'risk altında', 'tone' => 'bad']],
                        'feedback' => 'Temizlenmemiş bir ağa yüklenen yedek yeniden şifrelenebilir; bağlıyken çevrimdışı yedeğin bile bulaşabilir.',
                    ],
                ],
            ],
            's6' => [
                'time' => '14:00',
                'text' => 'Olay kontrol altında. Kanıt ve bildirim konusunda ne yaparsın?',
                'choices' => [
                    [
                        'label' => 'Fidye notunu ve kayıtları saklar, olayı yetkililere (örneğin USOM / siber olaylara müdahale ekibi) bildiririm; gerekirse uzman bir firmayla çalışırım.',
                        'to' => 's7', 'tone' => 'good', 'score' => 1, 'flags' => ['reported'],
                        'feedback' => 'Bildirmek hem bir sorumluluk hem de başkalarının korunmasına yardımcı olur. Uzman desteği, gözden kaçanı yakalar.',
                    ],
                    [
                        'label' => 'Utanç olmasın; kimseye söylemez, sessizce hallederim.',
                        'to' => 's7', 'tone' => 'bad', 'score' => -1,
                        'feedback' => 'Saklamak yasal risk yaratır ve aynı saldırganın başkalarını vurmasını kolaylaştırır. Olayları gizlemek güvenlik sağlamaz.',
                    ],
                    [
                        'label' => 'Saldırganın adresini bulup karşı saldırı düzenlerim.',
                        'to' => 's7', 'tone' => 'bad', 'score' => -1,
                        'feedback' => 'Saldırıya uğramış olsan bile karşı saldırı suçtur ve çoğu zaman masum, ele geçirilmiş cihazlara zarar verir. Bu iş yetkililerin.',
                    ],
                ],
            ],
            's7' => [
                'time' => 'Ertesi gün',
                'text' => 'En zor kısım geçti. Peki bunun bir daha yaşanmaması için?',
                'choices' => [
                    [
                        'label' => 'Herkese parola sıfırlatır, iki adımlı doğrulamayı zorunlu yaparım; saldırının nasıl girdiğini ekibe anlatır, düzenli çevrimdışı yedeği ve yazılı bir olay planını kalıcı hâle getiririm.',
                        'to' => 'resolve', 'tone' => 'good', 'score' => 1, 'flags' => ['hardened'],
                        'feedback' => 'Asıl kazanç burada: aynı kapı bir daha açılmasın diye zayıf noktayı kapatmak ve ekibi hazırlamak.',
                    ],
                    [
                        'label' => 'Sistem geri geldi, iş devam ediyor; gerisi şimdilik beklesin.',
                        'to' => 'resolve', 'tone' => 'bad', 'score' => -1,
                        'feedback' => 'Ders çıkarılmayan bir olay, tekrarlanmayı bekleyen bir olaydır. Bir dahaki sefere aynı yerden girerler.',
                    ],
                ],
            ],
            'son_iyi' => [
                'ending' => 'success', 'time' => 'Kapanış', 'badge' => 'Olay kapandı',
                'title' => 'Kale ayakta kaldı',
                'text' => 'Hızlı izole ettin, kanıtı korudun, fidyeyi reddettin, temiz sistemlere yedekten döndün, olayı bildirdin ve açık kapıyı kapattın. İş birkaç saat aksadı ama veri kaybı olmadı, kimse fidye ödemedi ve saldırının girdiği delik kapandı. Gerçek bir ekibin günlerce uğraşacağı işi doğru sırayla yaptın.',
            ],
            'son_orta' => [
                'ending' => 'partial', 'time' => 'Kapanış', 'badge' => 'Atlatıldı',
                'title' => 'Atlatıldı, ama ucuz değil',
                'text' => 'Krizi atlattın ve en kötüsünü önledin, ama bazı adımlar eksikti ya da sırası yanlıştı. Aşağıdaki kararlarına bak: bir dahaki sefere daha hızlı izole et, kanıtı koru ve kurtarmadan önce açığı kapat. Baştan oynayıp kusursuz yolu deneyebilirsin.',
            ],
            'son_kotu' => [
                'ending' => 'fail', 'time' => 'Kapanış', 'badge' => 'Ağır kayıp',
                'title' => 'Pahalı bir ders',
                'text' => 'Fidye ödendi. Para gitti, dosyaların bir kısmı yine de açılmadı ve şirket artık ödeme yapan, bilinen bir hedef — büyük olasılıkla yeniden vurulacak. İyi haber: bu bir simülasyondu. Baştan oyna ve ödeme dışındaki yolu gör; neredeyse her zaman daha iyi bir yol vardır.',
            ],
        ],
    ];
@endphp

<x-layouts.mission :mission="$mission" :steps="['hazirlik' => 'Hazırlan', 'simulasyon' => 'Simülasyon']">
    <x-slot:intro>
        Buraya kadar tek tek dersler çalıştın. Şimdi hepsini aynı anda, baskı altında kullanma zamanı. Cuma sabahı şirkette bir fidye yazılımı
        saldırısı başlıyor ve sorumlu sensin. Her kararı sen vereceksin; kararların hikâyeyi değiştirecek ve geri alınmayacak. Hazır mısın?
    </x-slot:intro>

    <x-mission.step id="hazirlik" number="1" title="Olay müdahalesinin altı adımı">
        <div class="lesson">
            <p>
                Bir saldırı yaşandığında panik en büyük düşmandır. Güvenlik ekipleri bu yüzden ezbere bilinen bir sıra izler. Bu sıraya
                <strong>olay müdahalesi</strong> denir ve altı adımdan oluşur:
            </p>
        </div>

        <ol class="mt-6 flex flex-col gap-3">
            @foreach ([
                ['Hazırlık', 'Saldırı gelmeden önce: yedekler alınır, bir plan yazılır, kimin neyi yapacağı bellidir. En önemli adım, kriz başlamadan tamamlanandır.'],
                ['Tespit', 'Bir şeylerin ters gittiğini fark etmek: bir uyarı, kayıtlardaki bir iz ya da bir çalışanın telefonu.'],
                ['Sınırlama', 'Yayılmayı durdurmak. Etkilenen sistemi ağdan ayırmak, kanamayı durdurmak gibidir; her şeyden önce gelir.'],
                ['Yok etme', 'Zararlı yazılımı temizlemek ve saldırının girdiği açığı kapatmak. Açık kapanmadan iş bitmez.'],
                ['Kurtarma', 'Temizlenmiş sistemlere çevrimdışı yedekten geri dönmek. Fidye ödemek değil; yedek, bu yüzden hayati.'],
                ['Ders çıkarma', 'Nasıl girdiler, ne öğrendik, bir daha nasıl önleriz? Bu adım atlanırsa olay tekrar eder.'],
            ] as [$name, $description])
                <li class="bg-card border-line flex gap-4 rounded-2xl border-2 p-4 sm:p-5">
                    <span aria-hidden="true" class="bg-rune/15 text-rune font-rune grid size-9 shrink-0 place-items-center rounded-xl text-sm font-bold">{{ $loop->iteration }}</span>
                    <span class="min-w-0">
                        <span class="font-display block text-xl leading-tight font-extrabold">{{ $name }}</span>
                        <span class="text-muted mt-1 block leading-relaxed">{{ $description }}</span>
                    </span>
                </li>
            @endforeach
        </ol>

        <x-callout tone="warning" title="İki altın kural" class="mt-8">
            <strong class="font-bold">Panik yapma, sırayı izle.</strong> Bir de: <strong class="font-bold">fidye ödemek bir çözüm değildir.</strong>
            Ödemek dosyaların geri geleceğini garanti etmez, suçluları besler ve seni tekrar hedef yapar. Gerçek çözüm hazırlık ve yedektir.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="simulasyon" number="2" title="Cuma 08:42 — Fidye">
        <div class="lesson">
            <p>
                Aşağıdaki simülasyonda sen Kale Lojistik’in bilişim sorumlususun. Her adımda bir karar ver. Seçimin anında kilitlenir ve sonucunu
                görürsün; üstteki durum tablosu kararlarına göre değişir. Sonunda olayı nasıl kapattığını göreceksin. İstersen baştan oynayıp başka bir
                yol deneyebilirsin. Buradaki şirket ve kişiler uydurmadır.
            </p>
        </div>

        <x-incident :scenario="$scenario" requirement="Fidye yazılımı olayını sonuna kadar yönet" class="mt-6" />
    </x-mission.step>
</x-layouts.mission>
