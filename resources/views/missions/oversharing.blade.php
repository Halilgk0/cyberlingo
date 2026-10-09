<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Bir doğum günü kutlaması, bir tatil fotoğrafı, kedinin adı… Tek başına zararsız görünen paylaşımlar birleşince bir saldırgana
        senin hakkında bir harita çizer. Bu görevde saldırganların profilinde neye baktığını öğrenecek, sonra bir profilde gizlenmiş tehlikeli bilgileri bulacaksın.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Dijital ayak izin">
        <div class="lesson">
            <p>
                İnternete koyduğun her paylaşım bir iz bırakır; buna <strong>dijital ayak izi</strong> denir. Paylaşımı sonradan silsen bile
                biri ekran görüntüsü almış ya da bir arşiv sitesi kaydetmiş olabilir. Bu yüzden en iyi kural basit: <strong>paylaşmadan önce düşün.</strong>
            </p>

            <h3>Saldırganlar profilini neden inceler?</h3>
            <ul>
                <li><strong>Güvenlik sorularını cevaplamak için:</strong> “İlk evcil hayvanınızın adı?”, “İlk okulunuz?” Bu soruların cevapları çoğu zaman profilinde yazıyor.</li>
                <li><strong>Parolanı tahmin etmek için:</strong> Doğum tarihin, tuttuğun takım, kedinin adı… Parola görevinden hatırla: saldırganlar önce bunları dener.</li>
                <li><strong>Sana özel oltalama hazırlamak için:</strong> Okulunu ve arkadaşlarını bilen biri “okul yönetiminden” geliyormuş gibi ikna edici bir mesaj yazabilir. Buna <em>hedefli oltalama</em> denir.</li>
                <li><strong>Gerçek hayatta zarar vermek için:</strong> Ev adresin, anlık konumun ya da “iki hafta tatildeyiz” paylaşımı hırsızlara yol gösterir.</li>
            </ul>

            <h3>Paylaşmadan önce kendine sor</h3>
            <ol>
                <li>Bunu hiç tanımadığım biri görse sorun olur mu?</li>
                <li>Bu bilgi bir güvenlik sorusunun ya da parolamın parçası olabilir mi?</li>
                <li>Fotoğrafın arka planında adres, araç plakası, belge, okul adı ya da ekran görüntüsü var mı?</li>
                <li>Konum etiketi açık mı? Şu an nerede olduğumu herkese duyuruyor muyum?</li>
            </ol>

            <h3>Herkese açık paylaşılmaması gerekenler</h3>
        </div>

        <ul class="mt-5 grid gap-2 sm:grid-cols-2">
            @foreach ([
                'TC kimlik numarası ve kimlik fotoğrafı',
                'Pasaport, ehliyet ya da öğrenci kartı',
                'Biniş kartı ve bilet barkodları',
                'Ev adresi ve evinin önünden fotoğraflar',
                'Anlık konum ve “şu an buradayım” paylaşımları',
                'Tatildeyken “evde yokuz” bilgisi',
                'Telefon numarası',
                'Banka kartı ve ödeme ekranları',
            ] as $item)
                <li class="bg-card border-line flex items-center gap-3 rounded-xl border px-4 py-3 font-bold">
                    <span aria-hidden="true" class="bg-alert/12 text-alert grid size-7 shrink-0 place-items-center rounded-full">✗</span>
                    {{ $item }}
                </li>
            @endforeach
        </ul>

        <x-callout title="Gizlilik ayarlarını bir kez gözden geçir" class="mt-8">
            Hesabını gizli yap, fotoğraflardaki konum etiketini kapat, seni kimlerin etiketleyebileceğini ve telefon numaranla kimlerin bulabileceğini sınırla.
            Bu ayarlar çoğu uygulamada <strong class="font-bold">Ayarlar › Gizlilik</strong> altında. Takipçi listende tanımadığın hesaplar varsa onları da çıkar.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Bilgi avcısı">
        <div class="lesson">
            <p>
                Aşağıda Elif’in herkese açık profili var. Bir saldırganın işine yarayacak <strong>7 bilgiyi</strong> bul ve üzerlerine tıkla.
                Doğru yere tıkladığında bilgi işaretlenir ve neden tehlikeli olduğu sağdaki listeye eklenir. Takılırsan ipucu iste.
            </p>
            <p class="text-muted text-base">Bu profildeki kişi, okul, numara ve adres uydurmadır.</p>
        </div>

        <div data-leak-hunt data-requirement="Profildeki 7 tehlikeli bilgiyi bul" class="mt-6 grid items-start gap-6 lg:grid-cols-[1fr_20rem]">
            <article aria-label="Elif Kaya’nın profili" class="bg-card border-line overflow-hidden rounded-[1.25rem] border">
                <div aria-hidden="true" class="from-signal/70 to-safe/50 h-24 bg-linear-to-r"></div>
                <div class="px-5 pb-5 sm:px-6">
                    <span aria-hidden="true" class="bg-signal border-card font-sans -mt-10 grid size-20 place-items-center rounded-full border-4 text-3xl font-extrabold text-[#10203a]">E</span>
                    <p class="font-sans mt-3 text-2xl font-extrabold tracking-tight">Elif Kaya</p>
                    <p class="text-muted">@elif.kaya09 · Herkese açık hesap</p>
                    <div class="mt-3 flex flex-col gap-1 text-lg leading-relaxed">
                        <p>
                            🎂 <x-leak label="Doğum tarihi" risk="Parola tahmininde ve bazı kurumların kimlik doğrulamasında kullanılır.">14 Mart 2009</x-leak>
                            · 📚 <x-leak label="Okul ve sınıf" risk="Seni gerçek hayatta bulmayı ve “okul yönetiminden” geliyormuş gibi görünen hedefli oltalama mesajları yazmayı kolaylaştırır.">Mavi Tepe Anadolu Lisesi 10-B</x-leak>
                        </p>
                        <p>📞 <x-leak label="Telefon numarası" risk="Dolandırıcı SMS’lerin ve aramaların hedefi olursun. Numaran başka hesaplarını bulmak için de kullanılabilir.">0500 000 12 34</x-leak> (DM’lere bakmıyorum, arayın 😅)</p>
                    </div>
                    <p class="text-muted mt-3"><strong class="text-ink">412</strong> takipçi · <strong class="text-ink">380</strong> takip</p>
                </div>

                <ol class="border-line divide-line flex flex-col divide-y border-t">
                    <li class="px-5 py-5 sm:px-6">
                        <p class="text-muted text-sm"><strong class="text-ink">Elif Kaya</strong> · 2 saat önce</p>
                        <p class="mt-2 text-lg">Tatil başlıyooor ✈️☀️</p>
                        <x-leak block label="Biniş kartı barkodu" risk="Barkodda adın ve rezervasyon kodun (PNR) var. Bunlarla biri uçuşunu değiştirebilir ya da iptal edebilir." class="mt-3">
                            <span class="block rounded-xl border-2 border-dashed border-[#9aabc2] bg-white p-4 font-mono text-sm text-[#10203a]">
                                <span class="block font-bold tracking-wide">BİNİŞ KARTI · BOARDING PASS</span>
                                <span class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1">
                                    <span>YOLCU: KAYA/ELİF</span>
                                    <span>UÇUŞ: MV 2417</span>
                                    <span>KOLTUK: 14C</span>
                                    <span>İSTANBUL → ANTALYA</span>
                                    <span>15 TEMMUZ</span>
                                    <span>PNR: K7X2QM</span>
                                </span>
                                <span aria-hidden="true" class="mt-3 flex h-10 items-stretch gap-[2px]">
                                    @foreach (str_split('3121132112311213121131221312113211231121') as $barWidth)
                                        <span class="bg-[#10203a]" style="width: {{ $barWidth }}px"></span>
                                    @endforeach
                                </span>
                            </span>
                        </x-leak>
                    </li>

                    <li class="px-5 py-5 sm:px-6">
                        <p class="text-muted text-sm"><strong class="text-ink">Elif Kaya</strong> · Dün</p>
                        <p class="mt-2 text-lg leading-relaxed">
                            <x-leak label="Evde olmadığınız tarihler" risk="Evin iki hafta boyunca boş olacağını herkese duyurur. Tatil fotoğraflarını eve dönünce paylaş.">Yarından itibaren 2 hafta Antalya’dayız</x-leak>,
                            ev Pamuk’a emanet 😎 #tatil #yaz
                        </p>
                    </li>

                    <li class="px-5 py-5 sm:px-6">
                        <p class="text-muted text-sm"><strong class="text-ink">Elif Kaya</strong> · 3 gün önce</p>
                        <p class="mt-2 text-lg leading-relaxed">Bugün Küçük Prens’i bitirdim. “Asıl görülmesi gereken, gözle görülmez.” 📖✨</p>
                    </li>

                    <li class="px-5 py-5 sm:px-6">
                        <p class="text-muted text-sm"><strong class="text-ink">Elif Kaya</strong> · 1 hafta önce</p>
                        <p class="mt-2 text-lg leading-relaxed">
                            <x-leak label="İlk evcil hayvanın adı" risk="“İlk evcil hayvanınızın adı?” çok yaygın bir güvenlik sorusu. Evcil hayvan adları sık kullanılan parola parçalarıdır da.">İlk kedim Pamuk</x-leak>
                            bugün 3 yaşında oldu! 🎉🐱
                        </p>
                        <div aria-hidden="true" class="bg-signal/20 mt-3 grid h-36 place-items-center rounded-xl text-6xl">🐱🎂</div>
                    </li>

                    <li class="px-5 py-5 sm:px-6">
                        <p class="text-muted text-sm"><strong class="text-ink">Elif Kaya</strong> · 2 ay önce</p>
                        <p class="mt-2 text-lg leading-relaxed">Yeni evimizin balkonundan manzara 😍</p>
                        <p class="text-muted mt-1">📍 <x-leak label="Ev adresi" risk="Nerede yaşadığını herkese gösterir. Tatil paylaşımıyla birleşince evin ne zaman boş olduğu da belli olur." class="text-ink font-bold">Gül Sokak No: 12, Kadıköy</x-leak></p>
                        <div aria-hidden="true" class="bg-safe/15 mt-3 grid h-36 place-items-center rounded-xl text-6xl">🌇</div>
                    </li>
                </ol>
            </article>

            <aside aria-labelledby="leak-tracker-heading" class="bg-card border-line rounded-[1.25rem] border p-5 lg:sticky lg:top-6">
                <h3 id="leak-tracker-heading" class="font-display text-xl font-extrabold tracking-tight">Bulduğun bilgiler</h3>
                <p class="text-muted mt-1"><span data-leak-count class="text-ink font-bold">0</span> / <span data-leak-total>7</span> bulundu</p>
                <div aria-hidden="true" class="bg-line mt-2 h-2 overflow-hidden rounded-full">
                    <div data-leak-bar class="bg-signal h-full w-0 rounded-full transition-[width] duration-300"></div>
                </div>
                <p data-leak-status aria-live="polite" class="text-safe mt-3 font-bold empty:hidden"></p>
                <ol data-leak-found class="mt-4 flex flex-col gap-3 empty:hidden"></ol>
                <button type="button" data-leak-hint class="btn-secondary mt-4 w-full">İpucu ver</button>

                <template data-leak-item>
                    <li class="border-signal border-l-4 pl-3">
                        <p data-leak-item-label class="font-bold"></p>
                        <p data-leak-item-risk class="text-muted mt-0.5 text-sm leading-relaxed"></p>
                    </li>
                </template>
            </aside>
        </div>

        <section data-leak-summary tabindex="-1" aria-labelledby="leak-summary-heading" class="bg-card border-line mt-6 rounded-[1.25rem] border p-6 focus:outline-none sm:p-8" hidden>
            <h3 id="leak-summary-heading" class="font-display text-2xl leading-tight font-extrabold tracking-tight">Saldırgan bu bilgileri birleştirince…</h3>
            <ul class="mt-4 flex flex-col gap-3 text-lg leading-relaxed">
                <li><strong class="font-bold">Hesabını ele geçirmeyi dener:</strong> “Şifremi unuttum” der, güvenlik sorusuna “Pamuk” yazar.</li>
                <li><strong class="font-bold">Parolasını tahmin eder:</strong> Pamuk2009, Elif1403, MaviTepe10B… Parola görevinde gördüğün gibi ilk denenenler bunlar.</li>
                <li><strong class="font-bold">İkna edici bir tuzak kurar:</strong> “Mavi Tepe Anadolu Lisesi 10-B: karne bilgilendirmesi” başlıklı bir e-posta ya da 0500’lü numaraya bir SMS.</li>
                <li><strong class="font-bold">Evi soymayı planlar:</strong> Gül Sokak No: 12, 15 Temmuz’dan itibaren iki hafta boş.</li>
            </ul>
            <p class="text-muted mt-4 text-lg leading-relaxed">Tek tek zararsız görünen yedi bilgi, bir yabancıya Elif’in hayatının haritasını verdi.</p>
        </section>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bir site, hesap kurtarma için “İlk evcil hayvanınızın adı?” sorusunu soruyor ve kedinin adı profilinde yazıyor. En iyi çözüm hangisi?">
                <x-quiz.option>Gerçek cevabı yazarım; kimse bilmez.</x-quiz.option>
                <x-quiz.option correct>Gerçek cevap yerine rastgele bir cevap yazar, onu parola yöneticimde saklarım.</x-quiz.option>
                <x-quiz.option>Cevabı büyük harfle yazarım, böylece tahmin edilemez.</x-quiz.option>

                <x-slot:explanation>
                    Güvenlik sorusuna gerçeği yazmak zorunda değilsin. Rastgele bir cevap, parola gibi davranır ve profilinden bulunamaz.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Tatil fotoğraflarını ne zaman paylaşmak daha güvenlidir?">
                <x-quiz.option>Yola çıkmadan önce, herkes haberdar olsun diye.</x-quiz.option>
                <x-quiz.option>Tatil sırasında, anlık konumla birlikte.</x-quiz.option>
                <x-quiz.option correct>Eve döndükten sonra.</x-quiz.option>

                <x-slot:explanation>
                    Tatildeyken yapılan paylaşımlar evinin boş olduğunu duyurur. Anılarını eve dönünce paylaşmak, aynı keyfi risksiz yaşatır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Yeni aldığın uçak biletinin fotoğrafını paylaşmak neden risklidir?">
                <x-quiz.option>Bilet fotoğrafları uygulamalarda kötü görünür.</x-quiz.option>
                <x-quiz.option correct>Barkodda adın ve rezervasyon kodun var; biri uçuşunu değiştirebilir ya da iptal edebilir.</x-quiz.option>
                <x-quiz.option>Hiçbir riski yoktur, bilet zaten satın alınmıştır.</x-quiz.option>

                <x-slot:explanation>
                    Biniş kartlarındaki barkod, okunduğunda adını ve rezervasyon kodunu verir. Bu ikisiyle havayolunun sitesinde rezervasyonuna erişilebilir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
