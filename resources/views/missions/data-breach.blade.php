<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Raporu oku', 'sina' => 'Sına']">
    <x-slot:intro>
        Kaleni ne kadar iyi korursan koru, eşyalarını emanet ettiğin komşunun deposu soyulabilir. İnternette buna veri sızıntısı denir ve
        çoğu zaman senin hatan değildir. Bu görevde bir sızıntının sana ne anlattığını okumayı ve her sızıntıya doğru önlemi seçmeyi öğreneceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Depo soyulduğunda">
        <div class="lesson">
            <p>
                <strong>Veri sızıntısı</strong>, bir şirketin ya da kurumun sakladığı bilgilerin izinsiz olarak dışarı çıkmasıdır. Üye olduğun bir forum,
                alışveriş sitesi ya da oyun saldırıya uğrar; kullanıcı listesi internette satılır ya da herkese açık yayımlanır. Senin bir hata yapman gerekmez.
            </p>
            <p>
                Önemli olan, soygun haberini aldığında ne yaptığındır. Çünkü saldırganlar sızan bilgileri hemen kullanmaya başlar.
            </p>

            <h3>Sızan bilgilerle neler yapılır?</h3>
            <ul>
                <li>
                    <strong>Kimlik bilgisi doldurma:</strong> Sızan e-posta ve parola çiftleri, programlarla yüzlerce farklı sitede otomatik olarak denenir.
                    Aynı parolayı birden fazla yerde kullanıyorsan, bir sitedeki sızıntı diğer hesaplarının kapısını da açar.
                </li>
                <li><strong>Hedefli oltalama:</strong> Adını, telefonunu, adresini, hatta son siparişini bilen bir mesaj çok daha inandırıcıdır.</li>
                <li><strong>Şantaj:</strong> Eski bir parolanı e-postaya yazıp “bilgisayarına girdim, seni kaydettim” diye korkutmak.</li>
                <li><strong>Dolandırıcılık:</strong> Çalınan kart bilgileriyle alışveriş, kimlik bilgileriyle senin adına işlem yapmaya çalışmak.</li>
            </ul>

            <h3>Haberini nereden alırsın?</h3>
            <ul>
                <li>
                    <strong>Şirketin kendisinden.</strong> Türkiye’de Kişisel Verilerin Korunması Kanunu (KVKK), verileri sızan kişilere ve Kişisel Verileri
                    Koruma Kurulu’na en kısa sürede haber verilmesini zorunlu tutar.
                </li>
                <li>
                    <strong>Sızıntı kontrol servislerinden.</strong> Have I Been Pwned (haveibeenpwned.com) gibi sitelerde e-posta adresini yazıp bilinen
                    sızıntılarda geçip geçmediğine bakabilirsin.
                </li>
                <li><strong>Parola kasandan ya da tarayıcından.</strong> Birçoğu, kayıtlı parolalarından biri bir sızıntıda görülürse seni uyarır.</li>
            </ul>
            <p>
                Dikkat: “Hesabınız bir sızıntıda bulundu, hemen tıklayın” diyen oltalama e-postaları da vardır. Uyarı gelse bile bağlantıya tıklama;
                siteyi ya da uygulamayı kendin aç.
            </p>

            <h3>Ne sızdıysa ona göre davran</h3>
        </div>

        <ul class="mt-6 grid gap-3 sm:grid-cols-2">
            @foreach ([
                ['🔑', 'Parola', 'O parolayı kullandığın her yerde değiştir ve iki adımlı doğrulamayı aç. İşe e-postandan başla.'],
                ['💳', 'Kart bilgisi', 'Bankanı resmi numarasından ara, kartı kapattır ve hesap hareketlerini kontrol et.'],
                ['📮', 'E-posta, telefon, adres', 'Bunları değiştiremezsin ama tetikte ol: bu bilgileri bilen mesajlar gerçek olduğunu kanıtlamaz.'],
                ['🪪', 'Kimlik no, doğum tarihi', 'Bunları parola ya da güvenlik sorusu olarak kullanma. “Bilgilerinizi doğruluyorum” diyerek bunları söyleyen arayana güvenme.'],
            ] as [$emoji, $leaked, $action])
                <li class="bg-card border-line flex gap-4 rounded-2xl border-2 p-4 sm:p-5">
                    <span aria-hidden="true" class="bg-paper grid size-12 shrink-0 place-items-center rounded-xl text-2xl">{{ $emoji }}</span>
                    <span class="min-w-0">
                        <span class="font-display block text-xl leading-tight font-extrabold sm:text-2xl">{{ $leaked }} sızdıysa</span>
                        <span class="text-muted mt-1 block leading-relaxed">{{ $action }}</span>
                    </span>
                </li>
            @endforeach
        </ul>

        <x-callout title="“Karıştırılmış parola” güvende mi?" class="mt-8">
            Düzgün siteler parolanı olduğu gibi değil, geri çevrilemeyen bir matematik işlemiyle karıştırarak (<em>hash</em>) saklar. Saldırgan bu karışımı
            geri çeviremez, ama milyarlarca tahmini aynı işlemden geçirip eşleşme arar. “123456” saniyeler içinde bulunur; uzun ve benzersiz bir parola
            ise yıllarca dayanır. Yani “parolalar şifreliydi” açıklaması, zayıf bir parolayı kurtarmaz.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Sızıntı raporunu oku">
        <div class="lesson">
            <p>
                Ayşe, e-posta adresini bir sızıntı kontrol servisinde arattı. Raporu incele, sonra her olay için Ayşe’nin yapması gereken ilk şeyi seç.
            </p>
            <p class="text-muted text-base">Bu görevdeki tüm siteler ve kişiler uydurmadır.</p>
        </div>

        <figure class="mt-6 overflow-hidden rounded-[1.25rem] border border-[#d6dbe4] bg-[#f6f7fb] font-sans text-[#1b2230]">
            <div class="bg-[#1b2230] px-5 py-4 text-white">
                <p class="text-sm text-white/70">Sızıntı kontrolü</p>
                <p class="mt-1 font-bold break-all">ayse.yilmaz@eposta.example</p>
            </div>
            <div class="px-5 py-4">
                <p class="font-bold text-[#c0262d]">Bu adres 4 veri sızıntısında bulundu.</p>
                <ul class="mt-3 flex flex-col gap-2">
                    @foreach ([
                        ['KitapKurdu Forum', 'Mart 2019', 'E-posta, kullanıcı adı, parola (düz metin)'],
                        ['HızlıKargo', 'Ekim 2022', 'Ad soyad, telefon, ev adresi'],
                        ['OyunDiyarı', 'Haziran 2024', 'E-posta, kullanıcı adı, karıştırılmış parola'],
                        ['BiletKöşe', 'Ocak 2025', 'Kart numarası, son kullanma tarihi'],
                    ] as [$site, $date, $leaked])
                        <li class="rounded-xl border border-[#d6dbe4] bg-white px-4 py-3">
                            <p class="flex flex-wrap items-baseline justify-between gap-x-3">
                                <span class="font-bold">{{ $site }}</span>
                                <span class="text-sm text-[#5b6578]">{{ $date }}</span>
                            </p>
                            <p class="mt-1 text-sm text-[#5b6578]">Sızan: {{ $leaked }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
            <figcaption class="sr-only">Ayşe’nin sızıntı raporu</figcaption>
        </figure>

        <x-sorter
            :categories="['parola' => 'Parolayı değiştir', 'banka' => 'Bankayı ara', 'tetikte' => 'Tetikte ol']"
            question="Ayşe ilk olarak ne yapmalı?"
            requirement="Altı sızıntı olayında doğru önlemi seç"
            class="mt-8"
        >
            <x-sorter.card answer="parola" label="KitapKurdu: düz metin parola">
                KitapKurdu forumundan e-posta adresi ve parolası düz metin olarak sızdı. Ayşe aynı parolayı yıllardır e-postasında da kullanıyor.

                <x-slot:explanation>
                    Saldırganlar bu çifti otomatik programlarla yüzlerce sitede dener. Ayşe bu parolayı kullandığı her yerde hemen değiştirmeli;
                    işe e-postasından başlamalı ve iki adımlı doğrulamayı açmalı.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="tetikte" label="HızlıKargo: ad, telefon, adres">
                HızlıKargo’dan adı, telefon numarası ve ev adresi sızdı. Parola ya da kart bilgisi yok.

                <x-slot:explanation>
                    Değiştirilecek bir parola yok, ama bu bilgilerle çok inandırıcı mesajlar gelebilir: “Ayşe Hanım, Çiçek Sokak’taki adresinize kargonuz
                    teslim edilemedi.” Adını ve adresini bilmesi, mesajın gerçek olduğunu göstermez.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="banka" label="BiletKöşe: kart bilgileri">
                BiletKöşe’den kart numarası ve son kullanma tarihi sızdı.

                <x-slot:explanation>
                    Ayşe bankasını resmi numarasından aramalı, kartı kapattırıp yenisini istemeli ve son hesap hareketlerine bakmalı. Tanımadığı bir harcama
                    varsa itiraz edebilir. Banka uygulamasından internet alışverişini geçici olarak kapatmak da iyi bir ara önlem.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="parola" label="OyunDiyarı: karıştırılmış parola">
                OyunDiyarı’ndan kullanıcı adı ve karıştırılmış parolası sızdı. Site, “Parolalar şifreli saklanıyordu, endişelenmeyin” diyor.

                <x-slot:explanation>
                    Karıştırılmış parolalar doğrudan okunamaz, ama zayıf ya da yaygın bir parola tahminle kısa sürede bulunur. Ayşe güvende olduğunu
                    varsaymamalı; parolayı değiştirmeli ve başka bir yerde kullanıyorsa orada da değiştirmeli.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="tetikte" label="Randevu uygulaması: e-posta ve doğum tarihi">
                Bir hastane randevu uygulamasından e-posta adresi ve doğum tarihi sızdı.

                <x-slot:explanation>
                    Ayşe doğum tarihini bir parolada ya da güvenlik sorusunda kullanıyorsa onları değiştirmeli. Asıl yapacağı şey tetikte olmak:
                    “Randevunuz iptal edildi, bilgilerinizi güncelleyin” gibi oltalama mesajları gelebilir.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="parola" label="Şantaj e-postası">
                Bir e-posta geldi: “Parolanı biliyorum: kitap1987. Bilgisayarına girdim ve kameranla kayıt aldım. 48 saat içinde 500 dolar göndermezsen
                herkese yollarım.” kitap1987, Ayşe’nin yıllar önce kullandığı gerçek bir parola.

                <x-slot:explanation>
                    Bu çok yaygın bir şantaj tuzağı. Gönderen parolayı eski bir sızıntıdan buldu; bilgisayara girmedi, elinde kayıt da yok. Para gönderilmez,
                    yanıt verilmez. Ayşe bu parolayı hâlâ bir yerde kullanıyorsa değiştirmeli ve e-postayı istenmeyen olarak işaretlemeli.
                </x-slot:explanation>
            </x-sorter.card>

            <x-slot:summary>
                Bir sızıntıda önce neyin çalındığına bak: parola, kart ya da kişisel bilgi. Her birinin ilacı farklı. Her sitede farklı bir parola kullanıyorsan,
                bir sızıntı yalnızca tek bir kapıyı açar.
            </x-slot:summary>
        </x-sorter>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Üye olduğun bir forum sızdırıldı ve aynı parolayı e-postanda da kullanıyorsun. İlk ne yapmalısın?">
                <x-quiz.option>Forumdaki üyeliğimi silerim; sorun çözülür.</x-quiz.option>
                <x-quiz.option correct>E-posta parolamı hemen değiştirir, iki adımlı doğrulamayı açarım.</x-quiz.option>
                <x-quiz.option>Forumun yapacağı açıklamayı beklerim.</x-quiz.option>

                <x-slot:explanation>
                    Parola zaten saldırganların elinde; forumdan çıkmak onu geri almaz. Asıl tehlike aynı parolanın e-postanda da çalışması.
                    E-postan diğer hesaplarının anahtarı olduğu için ilk o korunmalı.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="“Kameranla seni kaydettim” diyen bir e-postada gerçekten eski bir parolan yazıyor. Bu ne anlama gelir?">
                <x-quiz.option>Bilgisayarıma girilmiş; istedikleri parayı göndermeliyim.</x-quiz.option>
                <x-quiz.option>E-postayı yanıtlayıp önce kanıt göndermelerini isterim.</x-quiz.option>
                <x-quiz.option correct>Parolam eski bir sızıntıdan bulunmuş. Para göndermem, o parolayı kullandığım yerde değiştiririm.</x-quiz.option>

                <x-slot:explanation>
                    Bu şantaj e-postaları binlerce kişiye aynı anda gönderilir; parola, inandırıcı görünsün diye eski bir sızıntıdan alınır.
                    Yanıt vermek, adresinin aktif olduğunu ve korktuğunu gösterir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Kimlik bilgisi doldurma saldırısına karşı en etkili önlem hangisi?">
                <x-quiz.option>Parolamı her ay değiştirmek.</x-quiz.option>
                <x-quiz.option correct>Her sitede farklı bir parola kullanmak.</x-quiz.option>
                <x-quiz.option>Sadece büyük ve tanınmış sitelere üye olmak.</x-quiz.option>

                <x-slot:explanation>
                    Bu saldırı, bir sitede sızan parolanın başka sitelerde de çalışmasına dayanır. Her sitede farklı bir parola varsa sızan parola
                    başka hiçbir kapıyı açmaz. Büyük siteler de sızdırılabilir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
