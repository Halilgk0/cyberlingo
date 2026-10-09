<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Parolan, hesaplarının ön kapısındaki kilit. Bu görevde saldırganların parolaları nasıl tahmin ettiğini öğrenecek,
        sonra parola laboratuvarında kendi güçlü parolanı kuracaksın.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Saldırganlar parolanı nasıl bulur?">
        <div class="lesson">
            <p>
                Saldırganlar genellikle parolanı “hacklemez”, <strong>tahmin eder</strong>. Bunu bir insan değil, saniyede
                milyarlarca deneme yapabilen bir bilgisayar yapar. En sık kullandıkları dört yol şunlar:
            </p>
            <ul>
                <li><strong>Kişisel bilgiler:</strong> Adın, doğum yılın, tuttuğun takım ya da evcil hayvanının adı. Bunların çoğu sosyal medyada zaten görünür.</li>
                <li><strong>Sözlük saldırısı:</strong> En sık kullanılan milyonlarca parola ve kelime sırayla denenir. “123456” ya da “qwerty” ilk saniyede bulunur.</li>
                <li><strong>Kaba kuvvet (brute force):</strong> Tüm harf ve rakam kombinasyonları tek tek denenir. Kısa parolalar buna dayanamaz.</li>
                <li><strong>Sızıntılar:</strong> Üye olduğun bir site saldırıya uğrarsa parolan internette dolaşmaya başlar. Aynı parolayı başka yerde de kullanıyorsan, o hesaplar da tehlikeye girer.</li>
            </ul>

            <h3>İyi bir parolanın üç kuralı</h3>
            <ol>
                <li><strong>Uzun olsun.</strong> En az 12 karakter. Her yeni karakter, denenmesi gereken olasılıkları katlayarak artırır.</li>
                <li><strong>Tahmin edilemesin.</strong> İsim, doğum yılı, yaygın kelime ya da “12345” gibi klavye dizileri içermesin.</li>
                <li><strong>Tek bir hesapta kullanılsın.</strong> Her hesap için ayrı bir parola seç.</li>
            </ol>
        </div>

        <x-callout title="İpucu: parola cümlesi kullan" class="mt-8">
            Birbiriyle ilgisi olmayan dört kelime seç, aralarına sembol koy, bir rakam ekle:
            <strong class="font-bold whitespace-nowrap">Mavi-Kedi-Sabah-Yürür-7</strong>.
            Hem uzun hem akılda kalıcı. Hepsini hatırlamak zor gelirse bir <strong class="font-bold">parola yöneticisi</strong>
            (parolalarını senin için saklayan uygulama) kullanabilirsin.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Parola laboratuvarı">
        <p class="max-w-[65ch] text-lg leading-relaxed">
            Aşağıya bir parola yaz ve bir bilgisayarın onu ne kadar sürede tahmin edebileceğini gör. Tüm kontrollerden geçen bir parola kurduğunda bu adım tamamlanır.
        </p>

        <div
            data-password-lab
            data-requirement="Parola laboratuvarında tüm kontrolleri geç"
            class="bg-card border-line mt-6 rounded-[1.25rem] border p-5 sm:p-7"
        >
            <x-callout tone="warning" title="Gerçek parolanı buraya yazma">
                Yazdığın hiçbir şey kaydedilmez ya da bir yere gönderilmez. Yine de iyi bir alışkanlık edin: gerçek parolalarını hiçbir deneme sitesine yazma.
            </x-callout>

            <label for="password-lab-input" class="mt-6 block font-bold">Deneme parolası</label>
            <input
                id="password-lab-input"
                data-password-input
                type="text"
                autocomplete="off"
                autocapitalize="off"
                spellcheck="false"
                placeholder="Bir parola yaz"
                class="border-line bg-paper focus:border-ink placeholder:text-muted/70 mt-2 w-full rounded-xl border-2 px-4 py-3 text-xl tracking-wide focus:outline-none"
            >

            <div class="mt-3 flex flex-wrap items-center gap-2">
                <span class="text-muted">Şunları da dene:</span>
                @foreach (['123456', 'galatasaray1905', 'Ahmet1990!'] as $samplePassword)
                    <button type="button" data-password-sample="{{ $samplePassword }}" class="border-line hover:border-ink focus-visible:outline-ink rounded-full border-2 px-3 py-0.5 font-bold focus-visible:outline-2 focus-visible:outline-offset-2">
                        {{ $samplePassword }}
                    </button>
                @endforeach
            </div>

            <div class="border-line mt-7 border-t pt-6">
                <div class="flex flex-wrap items-baseline justify-between gap-x-6 gap-y-1">
                    <p class="text-muted">Tahmini kırılma süresi</p>
                    <p class="font-bold">Güç: <span data-strength-label>henüz yok</span></p>
                </div>
                <p data-crack-time class="font-display mt-1 text-4xl leading-tight font-extrabold tracking-tight sm:text-5xl">…</p>

                <div class="mt-4 grid grid-cols-4 gap-1.5" aria-hidden="true">
                    @foreach (range(1, 4) as $segment)
                        <span data-strength-segment class="bg-line data-[fill=1]:bg-alert data-[fill=2]:bg-signal data-[fill=3]:bg-safe/65 data-[fill=4]:bg-safe h-2.5 rounded-full transition-colors"></span>
                    @endforeach
                </div>

                <p data-weak-parts class="mt-4 leading-relaxed" hidden></p>
            </div>

            <ul class="mt-6 grid gap-x-6 gap-y-2.5 sm:grid-cols-2">
                @foreach ([
                    'length' => 'En az 12 karakter',
                    'uppercase' => 'Büyük harf (A, B, Ç…)',
                    'lowercase' => 'Küçük harf (a, b, ç…)',
                    'digit' => 'Rakam (0–9)',
                    'symbol' => 'Sembol (! ? # - gibi)',
                    'unpredictable' => 'Yaygın kelime, isim, yıl ya da dizi yok',
                ] as $check => $label)
                    <li data-check="{{ $check }}" class="group flex items-center gap-2.5">
                        <span class="border-line group-data-[state=pass]:border-safe group-data-[state=pass]:bg-safe group-data-[state=fail]:border-alert/60 text-card grid size-6 shrink-0 place-items-center rounded-full border-2 transition-colors">
                            <svg class="hidden size-3.5 group-data-[state=pass]:block" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m3 8.5 3.2 3L13 4.5" />
                            </svg>
                        </span>
                        <span class="text-muted group-data-[state=pass]:text-ink">{{ $label }}</span>
                        <span data-check-state class="sr-only">karşılanmadı</span>
                    </li>
                @endforeach
            </ul>

            <p data-lab-status aria-live="polite" class="text-safe mt-6 font-bold empty:hidden"></p>

            <p class="text-muted mt-6 text-sm leading-relaxed">
                Süre, saniyede 10 milyar tahmin yapabilen bir saldırgana göre kabaca hesaplanır; gerçek bir ölçüm değil, fikir vermesi içindir.
            </p>
        </div>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bunlardan hangisi en güçlü parola?">
                <x-quiz.option>Ahmet1990</x-quiz.option>
                <x-quiz.option>P@ssw0rd</x-quiz.option>
                <x-quiz.option correct>Kirmizi-Bisiklet-Yagmur-42!</x-quiz.option>
                <x-quiz.option>123456789</x-quiz.option>

                <x-slot:explanation>
                    Uzunluk en önemli etkendir. Rastgele kelimelerden oluşan uzun bir parola cümlesi hem güçlü hem akılda kalıcıdır.
                    “P@ssw0rd” gibi harfleri sembolle değiştirmek ise saldırganların ilk denediği numaralardandır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Aynı parolayı birçok sitede kullanırsan ne olur?">
                <x-quiz.option>Bir şey olmaz, yeter ki parola güçlü olsun.</x-quiz.option>
                <x-quiz.option correct>Sitelerden biri sızdırılırsa, saldırgan aynı parolayla diğer hesaplarına da girmeyi dener.</x-quiz.option>
                <x-quiz.option>Siteler bunu fark eder ve hesabını kilitler.</x-quiz.option>

                <x-slot:explanation>
                    Sızan parolaların başka sitelerde otomatik olarak denenmesine <strong class="font-bold">kimlik bilgisi doldurma</strong>
                    (credential stuffing) denir. Parolan ne kadar güçlü olursa olsun, tekrar kullanırsan tek bir sızıntı hepsini açar.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="İki adımlı doğrulama (2FA) ne işe yarar?">
                <x-quiz.option>Parolanı iki kat uzun hale getirir.</x-quiz.option>
                <x-quiz.option correct>Parolan çalınsa bile giriş için ikinci bir kanıt ister, örneğin telefonuna gelen bir kod.</x-quiz.option>
                <x-quiz.option>Hesabına aynı anda iki kişinin girmesine izin verir.</x-quiz.option>

                <x-slot:explanation>
                    2FA, kapıya ikinci bir kilit takmak gibidir. Saldırgan parolanı bilse bile telefonun elinde olmadığı için içeri giremez.
                    Destekleyen her hesapta açman iyi bir fikir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
