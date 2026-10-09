<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'ayir' => 'Ayır', 'sina' => 'Sına']">
    <x-slot:intro>
        Sosyal medyada bir reklam: hayalindeki kulaklık yüzde 90 indirimde! Bu görevde sahte mağazaların nasıl çalıştığını öğrenecek,
        bir mağaza sayfasında tehlike işaretlerini avlayacak ve hangi alışverişin güvenli olduğuna karar vereceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Sahte mağaza nasıl çalışır?">
        <div class="lesson">
            <p>
                Dolandırıcılar birkaç saat içinde gerçeğine çok benzeyen bir mağaza sitesi ya da sosyal medya hesabı açabilir.
                Ünlü ürünlerin fotoğraflarını kopyalar, akıl almaz indirimler koyar ve reklam verirler. Sonuç genellikle üçünden biridir:
                ürün hiç gelmez, sahte ya da bozuk bir ürün gelir, ya da girdiğin kart bilgileri başka alışverişlerde kullanılır.
            </p>

            <h3>Yedi tehlike işareti</h3>
            <ol>
                <li><strong>Gerçek olamayacak kadar düşük fiyat.</strong> Yeni bir ürünün yüzde 70-90 indirimle satılması neredeyse her zaman yemdir.</li>
                <li><strong>Sadece havale ya da EFT ile ödeme.</strong> Kartla ödemede bankana itiraz edip paranı geri isteyebilirsin. Havalede gönderdiğin para çoğu zaman geri gelmez; dolandırıcılar bu yüzden havale ister.</li>
                <li><strong>Sahte aciliyet.</strong> “Son 3 ürün!”, sürekli baştan başlayan geri sayım sayaçları. Amaç düşünmeden satın almanı sağlamak.</li>
                <li><strong>Şüpheli adres.</strong> Marka adına eklenmiş kelimeler (resmi, indirim, outlet) ve alışılmadık uzantılar. Bağlantı görevindeki kuralı hatırla: alan adının sahibi kim?</li>
                <li><strong>Sahte yorumlar.</strong> Hepsi beş yıldız, hepsi aynı gün yazılmış, birbirine çok benzeyen kısa cümleler.</li>
                <li><strong>Kimliği belirsiz satıcı.</strong> Adres, telefon, vergi numarası yok; tek iletişim yolu bir mesajlaşma hesabı.</li>
                <li><strong>İade yok.</strong> “İade ve değişim yapılmaz” diyen bir mağaza, yasal haklarını baştan yok saymaya çalışıyor demektir.</li>
            </ol>

            <h3>Güvenli alışverişin dört alışkanlığı</h3>
            <ul>
                <li><strong>Mağazayı araştır.</strong> Sitenin adını “şikayet” ya da “dolandırıcı” kelimesiyle birlikte arat. Türkiye’de e-ticaret siteleri Ticaret Bakanlığı’nın <strong>ETBİS</strong> sistemine kayıtlı olmalı; kayıt bilgisi genellikle sitenin alt kısmında yer alır.</li>
                <li><strong>Kartla öde.</strong> Mümkünse internet alışverişleri için ayrı bir sanal kart kullan. Ödemede bankandan gelen <strong>3D Secure</strong> doğrulama ekranını bekle ve SMS’teki tutarın doğru olduğunu kontrol et.</li>
                <li><strong>Ödeme sayfasının adresine bak.</strong> Mağazadan bambaşka bir alan adına yönlendiriliyorsan dur.</li>
                <li><strong>Pazar yerinde, pazar yerinin içinde kal.</strong> Satıcı seni ödeme için WhatsApp’a ya da IBAN’a yönlendirirse, pazar yerinin koruması da biter.</li>
            </ul>
        </div>

        <x-callout tone="warning" title="Dolandırıldığını fark edersen" class="mt-8">
            Vakit kaybetmeden bankanı ara: kartla ödediysen işleme itiraz et ve kartını kapattır. Sohbetlerin, ödeme dekontunun ve sitenin
            ekran görüntülerini al. Ardından polise ya da savcılığa başvur. Ne kadar erken davranırsan paranı geri alma şansın o kadar artar.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Mağaza dedektifi">
        <div class="lesson">
            <p>
                Aşağıdaki mağaza sayfasında <strong>7 tehlike işareti</strong> gizli. Her birini bul ve üzerine tıkla. Bulduğun her işaret
                sağdaki listeye neden tehlikeli olduğuyla birlikte eklenir. Takılırsan ipucu iste.
            </p>
            <p class="text-muted text-base">Bu mağaza, marka ve ürün uydurmadır.</p>
        </div>

        <div data-leak-hunt data-requirement="Mağazadaki 7 tehlike işaretini bul" class="mt-6 grid items-start gap-6 lg:grid-cols-[1fr_20rem]">
            <article aria-label="Sahte mağaza sayfası" class="overflow-hidden rounded-[1.25rem] border-2 border-[#d6dbe4] bg-white text-[#1a2030]">
                <div class="flex items-center gap-2 border-b border-[#e3e7ee] bg-[#f3f5f9] px-4 py-2.5">
                    <span aria-hidden="true" class="flex gap-1.5">
                        <span class="size-3 rounded-full bg-[#d6dbe4]"></span>
                        <span class="size-3 rounded-full bg-[#d6dbe4]"></span>
                        <span class="size-3 rounded-full bg-[#d6dbe4]"></span>
                    </span>
                    <p class="min-w-0 rounded-2xl bg-white px-3 py-1 font-mono text-xs break-all sm:rounded-full sm:text-sm">
                        <x-leak label="Şüpheli adres" risk="Markanın resmi sitesi değil: “tini-resmi-indirim.shop” bir başkasının alan adı. Marka adına eklenen “resmi” ve “indirim” kelimeleri güven vermek için orada.">https://tini-resmi-indirim.shop/kulaklik</x-leak>
                    </p>
                </div>

                <div class="p-5 sm:p-6">
                    <p class="font-sans text-lg font-extrabold tracking-tight text-[#e0335a]">TINI RESMİ MAĞAZA</p>

                    <div class="mt-4 grid gap-5 sm:grid-cols-[10rem_1fr]">
                        <div aria-hidden="true" class="grid aspect-square place-items-center rounded-xl bg-[#f3f5f9] text-7xl">🎧</div>
                        <div>
                            <h3 class="font-sans text-2xl leading-tight font-extrabold">Tını Pro Kablosuz Kulaklık</h3>
                            <p class="mt-2 text-sm text-[#5b6578]">Gürültü engelleme, 30 saat pil ömrü, hızlı şarj. Ücretsiz kargo.</p>
                            <p class="mt-3">
                                <x-leak label="Gerçek olamayacak kadar düşük fiyat" risk="2.999 TL’lik yeni bir ürünün 299 TL’ye satılması neredeyse her zaman yemdir. Dolandırıcılar düşünmeden almanı ister.">
                                    <span class="text-[#8a93a5] line-through">2.999 TL</span>
                                    <span class="font-sans text-3xl font-extrabold text-[#e0335a]">299 TL</span>
                                    <span class="rounded bg-[#e0335a] px-1.5 py-0.5 text-sm font-bold text-white">%90 İNDİRİM</span>
                                </x-leak>
                            </p>
                            <p class="mt-3 text-sm font-bold text-[#c2410c]">
                                <x-leak label="Sahte aciliyet" risk="Her sayfa açılışında baştan başlayan sayaçlar ve “son 3 ürün” uyarıları, seni araştırmadan satın almaya zorlamak için var.">⏰ Kampanyanın bitmesine 04:59 · Son 3 ürün!</x-leak>
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 rounded-xl border border-[#e3e7ee] bg-[#f8f9fb] p-4 text-sm leading-relaxed">
                        <p class="font-bold">Ödeme seçenekleri</p>
                        <p class="mt-1">
                            <x-leak label="Sadece havale ile ödeme" risk="Kartla ödemede bankana itiraz edebilirsin; havalede bu koruma yok. “Havaleye ek indirim” teklifi seni korumasız bir ödemeye çekmek içindir.">Kredi kartı sistemimiz bakımdadır. Ödemeler yalnızca havale/EFT ile alınır; havaleye ek %10 indirim!</x-leak>
                        </p>
                        <p class="mt-2">
                            <x-leak label="İade yok" risk="İnternetten alınan çoğu üründe cayma hakkın var. “İade yapılmaz” diyen bir mağaza, yasal haklarını baştan yok saymaya çalışıyor.">İade ve değişim yapılmamaktadır.</x-leak>
                        </p>
                    </div>

                    <div class="mt-5">
                        <p class="font-bold">Müşteri yorumları</p>
                        <x-leak block label="Sahte yorumlar" risk="Hepsi beş yıldız, hepsi dakikalar önce ve hepsi aynı kalıpta. Gerçek ürünlerin yorumları farklı tarihlere yayılır ve olumsuz yorumlar da içerir." class="mt-2">
                            <span class="flex flex-col gap-2 text-sm">
                                @foreach (['Harika ürün çok güzel 👍', 'Çok güzel harika ürün tavsiye ederim', 'Harika ürün hızlı kargo çok güzel'] as $review)
                                    <span class="block rounded-lg bg-[#f3f5f9] px-3 py-2">
                                        <span class="text-[#d99a12]">★★★★★</span> {{ $review }}
                                        <span class="block text-xs text-[#8a93a5]">{{ $loop->iteration * 3 }} dakika önce</span>
                                    </span>
                                @endforeach
                            </span>
                        </x-leak>
                    </div>

                    <p class="mt-5 border-t border-[#e3e7ee] pt-4 text-sm text-[#5b6578]">
                        <x-leak label="Kimliği belirsiz satıcı" risk="Adres, sabit telefon, vergi numarası ya da ETBİS kaydı yok. Tek iletişim yolu bir mesajlaşma hesabı olan bir satıcıya ulaşman, bir sorun çıkınca imkânsızlaşır.">İletişim için sadece WhatsApp: 0500 000 56 78</x-leak>
                        · © 2026 Tını Resmi Mağaza
                    </p>
                </div>
            </article>

            <aside aria-labelledby="shop-tracker-heading" class="bg-card border-line rounded-[1.25rem] border-2 p-5 lg:sticky lg:top-24">
                <h3 id="shop-tracker-heading" class="font-display text-xl font-extrabold tracking-tight">Bulduğun işaretler</h3>
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

        <section data-leak-summary tabindex="-1" aria-labelledby="shop-summary-heading" class="bg-card border-line mt-6 rounded-[1.25rem] border-2 p-6 focus:outline-none sm:p-8" hidden>
            <h3 id="shop-summary-heading" class="font-display text-2xl leading-tight font-extrabold tracking-tight">Bu siparişi verseydin ne olurdu?</h3>
            <p class="text-muted mt-3 text-lg leading-relaxed">
                299 TL’yi havaleyle gönderirdin. Kargo takip numarası hiç gelmezdi, WhatsApp numarası bir hafta sonra kapanırdı ve site birkaç gün içinde
                başka bir adla yeniden açılırdı. Havale yaptığın için bankan da itiraz edemezdi. Yedi işaretin tek başına bile yeterli bir uyarı olduğunu unutma.
            </p>
        </section>
    </x-mission.step>

    <x-mission.step id="ayir" number="3" title="Güvenle alınır mı, uzak mı durulur?">
        <div class="lesson">
            <p>Altı farklı alışveriş durumu göreceksin. Her birinin güvenli mi yoksa şüpheli mi olduğuna karar ver.</p>
        </div>

        <x-sorter
            :categories="['guvenli' => 'Güvenle alınır', 'supheli' => 'Uzak dur']"
            question="Bu alışverişe ne dersin?"
            requirement="Altı alışveriş durumunu ayır"
            class="mt-6"
        >
            <x-sorter.card answer="supheli" label="Instagram’da 450 TL’lik telefon">
                Yeni açılmış bir Instagram hesabı, 15.000 TL’lik bir telefonu 450 TL’ye satıyor. Ödemeyi sadece bir IBAN’a istiyor.

                <x-slot:explanation>
                    Gerçek dışı fiyat, yeni hesap ve havale isteği bir arada. Bu, sahte mağazaların en klasik üçlüsü.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="guvenli" label="Bilinen zincirin kampanyası">
                Yıllardır bilinen bir mağaza zinciri, kendi sitesinde yüzde 20 indirim yapıyor. Kartla ve kapıda ödeme seçenekleri var.

                <x-slot:explanation>
                    Makul bir indirim, tanınan bir satıcı ve itiraz edebileceğin ödeme yöntemleri. Yine de adresin gerçekten o zincire ait olduğunu kontrol et.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="supheli" label="Başka adrese giden ödeme">
                Mağaza normal görünüyor ama “Ödemeye geç” düğmesi seni odeme-onay.top adlı bambaşka bir alan adına götürüyor.

                <x-slot:explanation>
                    Kart bilgilerini yazacağın sayfanın sahibi, mağaza değil başka biri. Kart bilgilerini çalmak için kurulmuş bir sayfa olabilir.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="guvenli" label="Köklü pazar yeri satıcısı">
                Büyük bir pazar yerinde dört yıldır satış yapan, binlerce değerlendirmesi olan bir satıcı. Ödeme, pazar yerinin kendi sistemiyle yapılıyor.

                <x-slot:explanation>
                    Pazar yerinin ödeme sistemi seni korur; satıcının geçmişi de güven verir. Satıcı seni pazar yerinin dışına çekmeye çalışmadığı sürece rahat olabilirsin.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="supheli" label="Adressiz site, aynı gün yorumları">
                Sitede adres, telefon ya da vergi numarası yok. Ürünün 40 yorumunun hepsi beş yıldız ve hepsi aynı gün yazılmış.

                <x-slot:explanation>
                    Kimliği belirsiz bir satıcı ve toplu üretilmiş yorumlar. Bir sorun çıktığında ulaşabileceğin kimse olmayacak.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="guvenli" label="ETBİS kayıtlı, iadesi açık site">
                Sitenin altında ETBİS kayıt bilgisi, adres ve vergi numarası var; iade koşulları açıkça yazıyor. Ödemede bankanın 3D Secure ekranı açılıyor.

                <x-slot:explanation>
                    Kayıtlı bir satıcı, açık iade koşulları ve bankanın doğrulama ekranı. Bunlar güvenli bir mağazanın işaretleri.
                </x-slot:explanation>
            </x-sorter.card>

            <x-slot:summary>
                Güvenli alışverişin özü üç soru: Satıcı kim, nasıl ödüyorum ve bir sorun çıkarsa paramı geri alabilir miyim?
            </x-slot:summary>
        </x-sorter>
    </x-mission.step>

    <x-mission.step id="sina" number="4" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bir mağaza, “kart sistemimiz bakımda” deyip havale ile ödeme istiyor. Bu neden risklidir?">
                <x-quiz.option>Havale daha pahalıdır.</x-quiz.option>
                <x-quiz.option correct>Havalede bankana itiraz edip paranı geri isteyemezsin; kartla ödemede bu hakkın var.</x-quiz.option>
                <x-quiz.option>Havale yavaş olduğu için ürün geç gelir.</x-quiz.option>

                <x-slot:explanation>
                    Kartla yapılan ödemelerde ürün gelmezse bankan aracılığıyla itiraz edebilirsin. Havalede para doğrudan dolandırıcının hesabına geçer ve geri almak çok zordur.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir mağazanın güvenilir olup olmadığını anlamak için hangisi en iyi ilk adımdır?">
                <x-quiz.option>Ürün fotoğraflarının kaliteli olup olmadığına bakmak.</x-quiz.option>
                <x-quiz.option>Sitedeki yorumların hepsinin olumlu olmasına güvenmek.</x-quiz.option>
                <x-quiz.option correct>Mağazanın adını “şikayet” kelimesiyle aratmak ve iletişim, adres, ETBİS bilgilerini kontrol etmek.</x-quiz.option>

                <x-slot:explanation>
                    Fotoğraflar ve yorumlar kolayca kopyalanır ya da uydurulur. Başkalarının deneyimleri ve satıcının resmi bilgileri çok daha güvenilir ipuçlarıdır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir pazar yerindeki satıcı, “buradan alırsan komisyon ödüyorum, WhatsApp’tan yaz, daha ucuza vereyim” diyor. Ne yapmalısın?">
                <x-quiz.option>Ucuz olduğu için WhatsApp’tan yazarım.</x-quiz.option>
                <x-quiz.option correct>Pazar yerinin dışına çıkmam; ödemeyi pazar yerinin kendi sisteminden yaparım.</x-quiz.option>
                <x-quiz.option>Önce yarısını gönderir, ürün gelince kalanını öderim.</x-quiz.option>

                <x-slot:explanation>
                    Pazar yerinin ödeme sistemi, ürün gelmezse paranı korur. Satıcı seni dışarı çekerse bu koruma kalmaz; yarı yarıya ödemek de sadece kaybını yarıya indirir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
