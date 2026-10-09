<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'ozet' => 'Özet laboratuvarı', 'sina' => 'Sına']">
    <x-slot:intro>
        Kayıt olurken yazdığın parola, sunucuya ulaştıktan sonra nereye gider? İyi bir site onu hiçbir zaman olduğu gibi saklamaz. Bu görevde
        parolaların nasıl saklandığını kendi elinle deneyecek, “tuz” denen küçük bir hilenin neden hayat kurtardığını göreceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Kodlama, şifreleme, özet">
        <div class="lesson">
            <p>Bu üç kelime çoğu zaman karıştırılır, ama güvenlikte bambaşka işler görürler:</p>
        </div>

        <ul class="mt-6 grid gap-3 sm:grid-cols-3">
            @foreach ([
                ['Kodlama', 'Base64 gibi', 'Veriyi başka bir biçime çevirir. Herkes geri çevirebilir; hiçbir şeyi gizlemez.'],
                ['Şifreleme', 'AES gibi', 'Anahtarı olan geri açabilir. Mesajlar ve dosyalar için kullanılır.'],
                ['Özet (hash)', 'SHA-256, bcrypt gibi', 'Tek yönlü bir parmak izidir; geri çevrilemez. Parolalar için kullanılır.'],
            ] as [$name, $example, $description])
                <li class="bg-card border-line rounded-2xl border-2 p-4 sm:p-5">
                    <span class="font-display block text-2xl leading-tight font-extrabold">{{ $name }}</span>
                    <span class="text-signal mt-0.5 block text-sm font-bold">{{ $example }}</span>
                    <span class="text-muted mt-2 block leading-relaxed">{{ $description }}</span>
                </li>
            @endforeach
        </ul>

        <div class="lesson mt-10">
            <h3>Özetin dört özelliği</h3>
            <ol>
                <li><strong>Aynı giriş, aynı özet.</strong> “kale” kelimesinin özeti her zaman, her bilgisayarda aynıdır.</li>
                <li><strong>Küçük değişiklik, bambaşka özet.</strong> Tek bir harf değişince özetin neredeyse tamamı değişir. Buna çığ etkisi denir.</li>
                <li><strong>Sabit uzunluk.</strong> Bir harfin de bir kitabın da SHA-256 özeti 64 karakterdir.</li>
                <li><strong>Geri çevrilemez.</strong> Özetten parolayı hesaplamanın bir yolu yoktur; ancak tahmin edip özetini karşılaştırarak bulunabilir.</li>
            </ol>
            <p>
                Giriş yaparken sunucu, yazdığın parolanın özetini alır ve kayıtlı özetle karşılaştırır. Parolanın kendisini hiç bilmesi gerekmez.
            </p>

            <h3>İki sorun ve iki çözüm</h3>
            <p>
                <strong>Aynı parola, aynı özet.</strong> İki kişi aynı parolayı seçerse özetleri de aynı olur. Üstelik saldırganlar yaygın parolaların özetlerini
                önceden hesaplayıp dev tablolarda (<strong>gökkuşağı tabloları</strong>) saklar. Çözüm <strong>tuz</strong>dur: her kullanıcıya rastgele bir değer
                eklenir ve özet ona göre alınır. Tuz gizli değildir, özetin yanında saklanır; işi gizlemek değil, her özeti benzersiz kılmaktır.
            </p>
            <p>
                <strong>Hız.</strong> SHA-256 çok hızlıdır ve bu, parolalar için kötü bir haberdir: güçlü bir ekran kartı saniyede on milyarlarca tahminin özetini
                hesaplayabilir. Bu yüzden parolalar <strong>bcrypt</strong> ya da <strong>Argon2</strong> gibi bilerek yavaşlatılmış fonksiyonlarla özetlenir. Aynı ekran
                kartı bcrypt ile saniyede yalnızca birkaç bin tahmin yapabilir. Sunucu için bir giriş biraz yavaşlar; saldırgan için milyarlarca deneme imkânsızlaşır.
            </p>
        </div>

        <div class="terminal mt-8">
            <p class="text-muted"># PHP’nin password_hash() fonksiyonunun ürettiği bir bcrypt özeti</p>
            <p class="mt-2 break-all"><span class="text-signal">$2y$</span><span class="text-rune">12$</span><span class="text-[#ff9ab0]">Q7nX1uS0fJm2Lw9KcR4bZe</span><span>1hV8tYp3dGq6sN0aW5rU2xE7iO4mB9c</span></p>
            <ul class="mt-4 flex flex-col gap-1 text-xs sm:text-sm">
                <li><span class="text-signal">$2y$</span> hangi algoritma: bcrypt</li>
                <li><span class="text-rune">12$</span> maliyet: büyüdükçe özetlemek katlanarak yavaşlar</li>
                <li><span class="text-[#ff9ab0]">22 karakter</span> rastgele tuz</li>
                <li><span>31 karakter</span> özetin kendisi</li>
            </ul>
        </div>
    </x-mission.step>

    <x-mission.step id="ozet" number="2" title="Özet laboratuvarı">
        <div class="lesson">
            <p>Buradaki hesaplamaların hepsi senin tarayıcında yapılır; yazdığın hiçbir şey bir yere gönderilmez. Yine de gerçek bir parolanı yazma.</p>
        </div>

        <section data-hash-lab data-requirement="Çığ etkisini gör" aria-labelledby="avalanche-heading" class="bg-card border-line mt-6 rounded-[1.25rem] border-2 p-5 sm:p-6">
            <h3 id="avalanche-heading" class="font-display text-2xl leading-tight font-extrabold">1. Çığ etkisi</h3>
            <p class="text-muted mt-1 leading-relaxed">Kutudaki kelimenin tek bir harfini değiştir, örneğin “kale”yi “kala” yap ve özete ne olduğuna bak.</p>

            <label for="hash-input" class="mt-4 block font-bold">Metin</label>
            <input id="hash-input" data-hash-input value="kale" autocomplete="off" autocapitalize="off" spellcheck="false" maxlength="64" class="field mt-2 font-mono">

            <p class="mt-4 font-bold">SHA-256 özeti</p>
            <p data-hash-output class="terminal mt-2 font-mono text-sm break-all" aria-live="off">…</p>
            <p data-hash-diff aria-live="polite" class="text-muted mt-2 font-bold empty:hidden"></p>
        </section>

        <section data-salt-lab data-password="Kale2024!" data-requirement="Aynı parolaları tuzla" aria-labelledby="salt-heading" class="bg-card border-line mt-6 rounded-[1.25rem] border-2 p-5 sm:p-6">
            <h3 id="salt-heading" class="font-display text-2xl leading-tight font-extrabold">2. Aynı parola, iki kullanıcı</h3>
            <p class="text-muted mt-1 leading-relaxed">Ayşe ve Mehmet aynı parolayı seçti: <code class="bg-ink/10 rounded px-1 font-mono">Kale2024!</code>. Önce özetlerine bak, sonra her birine tuz ekle.</p>

            <ul class="mt-4 flex flex-col gap-3">
                @foreach (['Ayşe', 'Mehmet'] as $learnerName)
                    <li data-salt-user class="border-line rounded-xl border p-4">
                        <p class="font-bold">{{ $learnerName }}</p>
                        <p class="text-muted mt-1 text-sm">Tuz: <span data-salt-value class="text-ink font-mono">yok</span></p>
                        <p data-salt-hash class="terminal mt-2 p-3 font-mono text-xs break-all sm:p-4 sm:text-sm">…</p>
                    </li>
                @endforeach
            </ul>

            <p data-salt-status aria-live="polite" class="data-[tone=correct]:text-safe data-[tone=wrong]:text-alert mt-4 font-bold"></p>
            <button type="button" data-salt-button class="btn-primary mt-4 w-full sm:w-auto">Her birine tuz ekle</button>
        </section>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Tuz neden gizli tutulmak zorunda değildir?">
                <x-quiz.option>Çünkü tuz zaten şifrelenmiştir.</x-quiz.option>
                <x-quiz.option correct>Çünkü görevi gizlemek değil, aynı parolaların özetlerini birbirinden farklı kılmaktır.</x-quiz.option>
                <x-quiz.option>Çünkü tuz, parolanın kendisidir.</x-quiz.option>

                <x-slot:explanation>
                    Tuz, özetin yanında açıkça saklanır. Her kullanıcının tuzu farklı olduğu için hazır tablolar işe yaramaz ve aynı parolalar
                    birbirini ele vermez; saldırgan her kullanıcı için ayrı ayrı tahmin yapmak zorunda kalır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir sitede parolaları saklamanın doğru yolu hangisi?">
                <x-quiz.option>Parolayı Base64 ile kodlamak.</x-quiz.option>
                <x-quiz.option>Parolayı SHA-256 ile bir kez özetlemek.</x-quiz.option>
                <x-quiz.option correct>bcrypt ya da Argon2 gibi yavaş ve tuzlu bir özet kullanmak (PHP’de password_hash).</x-quiz.option>

                <x-slot:explanation>
                    Base64 herkesin geri çevirebildiği bir kodlamadır. Tek başına SHA-256 hem tuzsuz hem çok hızlıdır. Yavaş ve tuzlu bir özet ise
                    sızıntı olsa bile tahmin etmeyi son derece pahalı hâle getirir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir site, “Parolamı unuttum” deyince parolanı e-postayla aynen geri gönderdi. Bu ne anlama gelir?">
                <x-quiz.option>Sitenin çok güvenli olduğunu.</x-quiz.option>
                <x-quiz.option correct>Parolaların geri çevrilebilir biçimde saklandığını; o sitede başka hiçbir yerde kullanmadığım bir parola olmalı.</x-quiz.option>
                <x-quiz.option>Normal; bütün siteler böyle yapar.</x-quiz.option>

                <x-slot:explanation>
                    Özetlenmiş bir parola geri çevrilemez; doğru yapılmış bir site sana yalnızca yeni parola belirleme bağlantısı gönderebilir.
                    Parolanı geri gönderebilen bir site onu okunabilir biçimde saklıyordur.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
