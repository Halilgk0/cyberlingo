@php
    /* The snippets are plain strings so nothing in them is ever run or rendered; the quiz shows them escaped. */
    $snippets = [
        'password' => <<<'CODE'
            // Kayıt formundan gelen parola
            $user->password = $request->input('password');
            $user->save();
            CODE,
        'invoice' => <<<'CODE'
            // /fatura/{numara} sayfası
            $invoice = Invoice::find($number);

            return view('invoice', ['invoice' => $invoice]);
            CODE,
        'search' => <<<'CODE'
            // Kitap arama kutusu
            $search = $request->input('q');
            $books = DB::select("SELECT * FROM books WHERE title = '$search'");
            CODE,
        'comment' => <<<'CODE'
            // Bir yorumun sayfada gösterilmesi
            echo '<p>' . $comment->body . '</p>';
            CODE,
        'secret' => <<<'CODE'
            // Sitenin tarayıcıda çalışan JavaScript dosyası
            const PAYMENT_SECRET_KEY = 'gizli-anahtar-7f3a9c';

            fetch('https://odeme.example/charge', {
                headers: { Authorization: PAYMENT_SECRET_KEY },
            });
            CODE,
    ];
@endphp

<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'incele' => 'Kodu incele', 'sina' => 'Sına']">
    <x-slot:intro>
        Açıkların çoğu kötü niyetten değil, gözden kaçan küçük satırlardan doğar. Bu görevde güvenli kodlamanın üç kuralını öğrenecek, sonra bir
        savunucu gibi beş kısa kod parçasını inceleyip her birindeki sorunu ve doğru düzeltmeyi bulacaksın. Hiç kod yazmamış olman sorun değil.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Güvenli kodlamanın üç kuralı">
        <div class="lesson">
            <p>
                Bir web sitesi, ziyaretçilerden sürekli bir şeyler alır: formlara yazılanlar, adres çubuğundaki sayılar, çerezler. Saldırganlar da tam bu
                kapılardan girmeye çalışır. Etik hackerların test ettiği, yazılımcıların da korumaya çalıştığı yerler buralardır.
            </p>

            <h3>1. Kullanıcıdan gelen hiçbir şeye güvenme</h3>
            <p>
                Bir forma yazılan her şey, beklediğin şey olmayabilir. Gelen veriyi kullanmadan önce doğrula: bir e-posta gerçekten e-posta mı,
                bir sayı gerçekten sayı mı, uzunluğu makul mü?
            </p>

            <h3>2. Veriyi komuttan ayır</h3>
            <p>
                Kullanıcının yazdığı metni bir komutun içine yapıştırırsan, metin komutun bir parçası gibi yorumlanabilir. Veritabanına giden sorgularda
                bu yüzden <strong>parametreli sorgu</strong> kullanılır; sayfaya yazılan metinler ise <strong>kaçışlanır</strong>, yani içindeki özel
                karakterler zararsız hâle getirilir.
            </p>

            <h3>3. Her istekte “Bu kişi buna yetkili mi?” diye sor</h3>
            <p>
                Giriş yapmış olmak, her şeye erişebilmek demek değildir. Bir fatura, mesaj ya da dosya istendiğinde, onun isteyen kişiye ait olup olmadığı
                her seferinde kontrol edilmelidir. Bu kontrolün unutulması o kadar yaygındır ki, web açıklarını listeleyen OWASP’ın son listelerinde
                “erişim kontrolü hataları” ilk sıradadır.
            </p>

            <h3>Ve iki alışkanlık</h3>
            <ul>
                <li><strong>Parolaları özetle.</strong> Parolalar asla olduğu gibi saklanmaz; geri çevrilemeyen bir özet hâlinde tutulur.</li>
                <li><strong>Sırları sunucuda tut.</strong> Tarayıcıya giden her kod, sayfayı açan herkes tarafından okunabilir.</li>
            </ul>
        </div>

        <x-callout title="Bu alıştırmadaki kodlar hakkında" class="mt-8">
            Kodlar PHP ve JavaScript ile yazılmış kısa örneklerdir; her satırı anlaman gerekmez. Yorum satırı (<code>//</code> ile başlayan) kodun ne
            yaptığını anlatır. Senden istenen, sorunu bir savunucu gözüyle fark etmek.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="incele" number="2" title="Beş kod parçasını incele">
        <x-quiz requirement="Beş kod parçasını incele">
            <x-quiz.question prompt="Bu kodda hangi sorun var?" :code="$snippets['password']">
                <x-quiz.option correct>Parola veritabanına olduğu gibi yazılıyor; özetlenerek saklanmalı.</x-quiz.option>
                <x-quiz.option>Parola çok uzun olabilir; en fazla 8 karakter olmalı.</x-quiz.option>
                <x-quiz.option>Bir sorun yok; veritabanı zaten güvende.</x-quiz.option>

                <x-slot:explanation>
                    Veritabanı bir gün sızarsa düz parolalar doğrudan okunur. Doğrusu, parolayı PHP’nin <code>password_hash()</code> fonksiyonuyla
                    geri çevrilemeyen bir özete dönüştürüp saklamak, girişte de <code>password_verify()</code> ile karşılaştırmaktır.
                    CyberLingo da parolaları böyle saklar.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bu fatura sayfasında hangi sorun var?" :code="$snippets['invoice']">
                <x-quiz.option>Fatura numarası çok kısa.</x-quiz.option>
                <x-quiz.option correct>Faturanın giriş yapan kişiye ait olup olmadığına bakılmıyor; numarayı değiştiren başkasının faturasını görür.</x-quiz.option>
                <x-quiz.option>Sayfa çok yavaş açılır.</x-quiz.option>

                <x-slot:explanation>
                    Sorumlu bildirim görevindeki kargo sitesinin açığı tam olarak buydu. Düzeltmesi tek satır: faturanın sahibi giriş yapan kişi değilse
                    sayfayı açmamak, örneğin <code>abort_unless($invoice->user_id === $request->user()->id, 403);</code> ile.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bu arama kutusunda hangi sorun var?" :code="$snippets['search']">
                <x-quiz.option>Kitap adı büyük harfle aranmalı.</x-quiz.option>
                <x-quiz.option>SELECT * yerine yalnızca başlık seçilirse sorun çözülür.</x-quiz.option>
                <x-quiz.option correct>Kullanıcının yazdığı metin sorgunun içine yapıştırılıyor; parametreli sorgu kullanılmalı.</x-quiz.option>

                <x-slot:explanation>
                    Metin sorguya yapıştırıldığında, veritabanı onun bir kısmını komut sanabilir. Bu açığın adı <strong>SQL enjeksiyonu</strong>dur.
                    Düzeltmesi, veriyi ayrı göndermektir: <code>DB::select('SELECT * FROM books WHERE title = ?', [$search]);</code> Veritabanı
                    soru işaretinin yerine geleni her zaman yalnızca veri olarak görür.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bu yorum gösterme kodunda hangi sorun var?" :code="$snippets['comment']">
                <x-quiz.option correct>Yorum, içindeki HTML ile birlikte sayfaya basılıyor; kaçışlanarak gösterilmeli.</x-quiz.option>
                <x-quiz.option>Yorumlar yalnızca büyük harfle gösterilmeli.</x-quiz.option>
                <x-quiz.option>Sorun yok; yorumu yazan zaten giriş yapmış biri.</x-quiz.option>

                <x-slot:explanation>
                    Kaçışlanmayan bir yorum, sayfayı açan başka ziyaretçilerin tarayıcısında kod çalıştırabilir. Bu açığa <strong>XSS</strong>
                    (siteler arası betik çalıştırma) denir. <code>htmlspecialchars($comment->body)</code> özel karakterleri zararsız metne çevirir;
                    Laravel’in şablonları da yazdırdıkları her şeyi varsayılan olarak böyle kaçışlar.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bu JavaScript kodunda hangi sorun var?" :code="$snippets['secret']">
                <x-quiz.option>Değişkenin adı Türkçe olmalı.</x-quiz.option>
                <x-quiz.option correct>Gizli anahtar tarayıcıya giden kodda duruyor; sayfayı açan herkes görebilir.</x-quiz.option>
                <x-quiz.option>fetch yerine başka bir fonksiyon kullanılmalı.</x-quiz.option>

                <x-slot:explanation>
                    Tarayıcıda çalışan her kod, geliştirici araçlarıyla okunabilir. Gizli anahtarlar yalnızca sunucuda durur: tarayıcı kendi sunucuna
                    istek atar, ödeme şirketiyle de sunucu konuşur.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Bir formdan gelen veriye ne zaman güvenmelisin?">
                <x-quiz.option>Form sitemin içindeyse her zaman.</x-quiz.option>
                <x-quiz.option>Kullanıcı giriş yapmışsa.</x-quiz.option>
                <x-quiz.option correct>Hiçbir zaman; her zaman doğrular ve dikkatle kullanırım.</x-quiz.option>

                <x-slot:explanation>
                    Forma ne yazılacağını sen değil, onu dolduran kişi belirler. Bu yüzden gelen her veri, nereden gelirse gelsin doğrulanır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Parametreli sorgu neyi sağlar?">
                <x-quiz.option correct>Kullanıcının yazdığı metin hep veri olarak kalır, komut olarak çalışmaz.</x-quiz.option>
                <x-quiz.option>Sorgunun daha hızlı çalışmasını; güvenlikle ilgisi yoktur.</x-quiz.option>
                <x-quiz.option>Veritabanındaki bütün verilerin şifrelenmesini.</x-quiz.option>

                <x-slot:explanation>
                    Komut ve veri ayrı ayrı gönderildiği için veritabanı ikisini asla karıştırmaz. SQL enjeksiyonuna karşı temel önlem budur.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir kullanıcı giriş yaptı. Bu, sitedeki bütün faturaları görebileceği anlamına mı gelir?">
                <x-quiz.option>Evet, giriş yapan herkes güvenilirdir.</x-quiz.option>
                <x-quiz.option correct>Hayır; her istekte istenen kaydın ona ait olup olmadığı ayrıca kontrol edilmeli.</x-quiz.option>
                <x-quiz.option>Yalnızca fatura numarasını biliyorsa evet.</x-quiz.option>

                <x-slot:explanation>
                    Kimlik doğrulama “Sen kimsin?” sorusunu, yetkilendirme “Buna iznin var mı?” sorusunu yanıtlar. İkisi farklıdır ve ikisi de gereklidir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
