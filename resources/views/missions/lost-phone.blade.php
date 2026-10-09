<x-layouts.mission :mission="$mission" :steps="['hazirlik' => 'Hazırlan', 'ilk-saat' => 'İlk saat', 'sina' => 'Sına']">
    <x-slot:intro>
        Telefonun bugün cebindeki en değerli kale: e-postan, bankan, fotoğrafların ve doğrulama kodların onun içinde. Bu kısa görevde telefonun
        kaybolmadan önce yapman gerekenleri ve kaybolduğu ilk saatte izlemen gereken sırayı öğreneceksin.
    </x-slot:intro>

    <x-mission.step id="hazirlik" number="1" title="Kaybolmadan önce: dört hazırlık">
        <ul class="grid gap-3 sm:grid-cols-2">
            @foreach ([
                ['🔒', 'Güçlü ekran kilidi', 'En az 6 haneli bir PIN ya da parola, yanında parmak izi veya yüz tanıma. Kilitsiz bir telefonu bulan kişi her şeyine erişir.'],
                ['📍', 'Cihazımı bul', 'Android’de “Cihazımı Bul”, iPhone’da “Bul” özelliğini açık tut. Kaybolan telefonu haritada görür, çaldırır, kilitler ya da uzaktan silersin.'],
                ['🔢', 'IMEI numarası', 'Telefonunda *#06# tuşlayıp 15 haneli IMEI numaranı gör ve telefonun dışında bir yere not et. Kayıp ya da çalıntı bildiriminde gerekir.'],
                ['☁️', 'Otomatik yedek', 'Fotoğrafların ve rehberin kendiliğinden yedeklensin. Telefon gitse de anıların gitmez.'],
            ] as [$emoji, $title, $description])
                <li class="bg-card border-line flex gap-4 rounded-2xl border-2 p-4 sm:p-5">
                    <span aria-hidden="true" class="bg-paper grid size-12 shrink-0 place-items-center rounded-xl text-2xl">{{ $emoji }}</span>
                    <span class="min-w-0">
                        <span class="font-display block text-xl leading-tight font-extrabold sm:text-2xl">{{ $title }}</span>
                        <span class="text-muted mt-1 block leading-relaxed">{{ $description }}</span>
                    </span>
                </li>
            @endforeach
        </ul>

        <div class="lesson mt-8">
            <p>
                Bir adım daha: SIM kartına bir <strong>PIN</strong> koy. Böylece telefonu bulan kişi SIM kartı başka bir telefona takıp senin
                doğrulama SMS’lerini alamaz.
            </p>
        </div>

        <x-callout title="Çalınan telefon Türkiye’de neden işe yaramaz hâle gelir?" class="mt-8">
            Telefonun kaybolduğunda ya da çalındığında operatörüne bildirirsen hattın kapatılır ve telefonun IMEI numarası kayıp-çalıntı listesine alınır.
            Bu listedeki telefonlar Türkiye’deki mobil şebekelerde çalışmaz. Telefonunu bulursan kaydı kaldırtabilirsin.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="ilk-saat" number="2" title="Telefonun kayboldu: ilk saat">
        <div class="lesson">
            <p>
                Akşam vapurdan indin ve telefonunun cebinde olmadığını fark ettin. Arkadaşının telefonunu ödünç aldın.
                Ne yapacağını sırayla seç; iki tuzağa dikkat.
            </p>
        </div>

        <x-response-plan requirement="Kayıp telefon planını kur" title="İlk saat planın" class="mt-6">
            <x-response-plan.step stage="3">
                Operatörünü arayıp hattını geçici olarak kapattır.

                <x-slot:why>
                    Hattın açıkken doğrulama SMS’lerin o telefona gitmeye devam eder. SIM kart başka bir telefona takılırsa kodların yabancı ellere geçer.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step trap>
                Haritada görünen adrese tek başına gidip telefonu geri iste.

                <x-slot:why>
                    Telefon çalındıysa bu seni tehlikeye atar. Konum bilgisini polisle paylaş; telefonun peşine tek başına düşme.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="1">
                Başka bir cihazdan “Cihazımı bul” ile telefonun konumuna bak ve çaldır.

                <x-slot:why>
                    Belki sadece vapurda koltuğun arasına düştü. Konum ve ses, kayıpların çoğunu dakikalar içinde çözer.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="4">
                Geri gelmeyeceğini anlayınca telefonu uzaktan sil ve çalıntı bildirimi yap.

                <x-slot:why>
                    Uzaktan silme bilgilerini korur, ama bazı telefonlarda sildikten sonra konumu artık göremezsin. Bu yüzden umudun kalmayınca yapılır.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="2">
                Telefonu kayıp moduna al: kilitle ve ekrana sana ulaşılabilecek bir numara yaz.

                <x-slot:why>
                    Kayıp modu telefonu kilitler ve bulan iyi niyetli kişiye sana nasıl ulaşacağını gösterir. Bazı telefonlarda kayıtlı ödeme kartlarını da askıya alır.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step trap>
                “Kayıp telefonunuz bulundu, konumu görmek için giriş yapın” diye gelen SMS’teki bağlantıdan hesabına gir.

                <x-slot:why>
                    Bu, hırsızların bilinen bir oyunu. Telefonun kilidini kaldırmak için senin hesap parolana ihtiyaçları var ve onu sahte bir
                    “telefonun bulundu” sayfasıyla isterler. Konuma yalnızca resmi uygulamadan bak.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="3">
                E-posta ve banka parolalarını başka bir cihazdan değiştir, telefondaki oturumları kapat.

                <x-slot:why>
                    Telefondaki açık oturumlar, kilit bir şekilde açılırsa doğrudan kapı açar. Bankanı arayıp mobil bankacılığını geçici olarak dondurtabilirsin.
                </x-slot:why>
            </x-response-plan.step>

            <x-slot:summary>
                Önce bul, sonra kilitle, ardından hattını ve hesaplarını koru, umudun kalmayınca da sil. Hazırlık yapmadıysan bu adımların çoğu mümkün olmaz:
                telefonun şu an elindeyse “Cihazımı bul” özelliğinin açık olduğundan emin ol.
            </x-slot:summary>
        </x-response-plan>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Telefonun kaybolmadan önce yapabileceğin en önemli hazırlık hangisi?">
                <x-quiz.option>Telefona sağlam bir kılıf takmak.</x-quiz.option>
                <x-quiz.option correct>Güçlü bir ekran kilidi koymak ve “Cihazımı bul” özelliğini açmak.</x-quiz.option>
                <x-quiz.option>Telefonu hep sessizde tutmak.</x-quiz.option>

                <x-slot:explanation>
                    Ekran kilidi, telefonu bulan kişiyi içeri sokmaz; “Cihazımı bul” ise telefonu uzaktan bulmanı, kilitlemeni ve silmeni sağlar.
                    Bunlar telefon kaybolduktan sonra açılamaz.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Uzaktan silme neden planın en sonunda?">
                <x-quiz.option>Çünkü silmek saatler sürer.</x-quiz.option>
                <x-quiz.option>Çünkü silinen telefon bir daha hiç kullanılamaz.</x-quiz.option>
                <x-quiz.option correct>Çünkü bazı telefonlarda sildikten sonra konum görülemez; önce bulmayı denemek gerekir.</x-quiz.option>

                <x-slot:explanation>
                    Silme bilgilerini korur ama telefonu bulma şansını azaltabilir. O yüzden önce bulmaya ve kilitlemeye çalışılır,
                    telefonun geri gelmeyeceği anlaşılınca silinir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
