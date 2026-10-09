<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Bir bağlantıya tıklamadan önce nereye gittiğini okuyabilmek, internetteki en işe yarar becerilerden biri.
        Bu görevde bir internet adresinin parçalarını öğrenecek, sonra sahte adresleri gerçeklerinden ayıracaksın.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Bir internet adresinin parçaları">
        <div class="lesson">
            <p>
                Her web sitesinin bir adresi vardır. Bu adrese <strong>URL</strong> da denir ve tarayıcının üst kısmındaki adres çubuğunda görünür.
                Örneğin bir bankanın giriş sayfasının adresi şöyle olabilir:
            </p>
        </div>

        <figure class="bg-card border-line mt-6 rounded-[1.25rem] border p-5 sm:p-7">
            <figcaption class="text-muted font-bold">Bir adresin dört parçası</figcaption>
            <div class="mt-4 flex flex-wrap items-start gap-x-1.5 gap-y-3 font-mono text-lg sm:text-2xl">
                @foreach ([['https://', 'protokol'], ['www.', 'alt alan adı'], ['mavibank.com.tr', 'alan adı'], ['/giris', 'yol']] as [$part, $partName])
                    <span class="flex flex-col gap-1.5">
                        <span @class(['rounded-md px-1', 'bg-safe/15 text-safe font-bold' => $partName === 'alan adı'])>{{ $part }}</span>
                        <span class="border-line text-muted border-t-2 px-1 pt-1 font-sans text-sm font-bold">{{ $partName }}</span>
                    </span>
                @endforeach
            </div>
        </figure>

        <div class="lesson mt-8">
            <ul>
                <li><strong>Protokol (https://):</strong> Bağlantının şifreli olduğunu söyler; bilgilerin yolda başkaları tarafından okunamaz. Ama sitenin kime ait olduğu hakkında hiçbir şey söylemez. Sahte siteler de https kullanır.</li>
                <li><strong>Alt alan adı (www.):</strong> Alan adının soluna eklenen kısım. Bunu alan adının sahibi istediği gibi seçer. Yani bir saldırgan kendi sitesinin başına “mavibank.com.tr.” bile yazabilir.</li>
                <li><strong>Alan adı (mavibank.com.tr):</strong> Adresin sahibini gösteren kısım. Her alan adının tek bir sahibi vardır. Bakman gereken asıl yer burası.</li>
                <li><strong>Yol (/giris):</strong> Sitenin içindeki sayfa. Buraya da herkes istediğini yazabilir.</li>
            </ul>

            <h3>Alan adını bulmanın kuralı</h3>
            <ol>
                <li>Adresin başındaki <strong>https://</strong> ya da <strong>http://</strong> kısmını atla.</li>
                <li>Ondan sonra gelen <strong>ilk eğik çizgiyi (/)</strong> bul. Eğik çizgi yoksa adresin sonuna git.</li>
                <li>Oradan <strong>sola doğru</strong> oku: en sondaki uzantı (.com, .com.tr, .xyz gibi) ve hemen solundaki kelime alan adıdır. Daha soldaki her şey alt alan adıdır.</li>
            </ol>

            <h3>Saldırganların dört numarası</h3>
            <ul>
                <li><strong>Gerçek adı alt alan adına koymak:</strong> <em>mavibank.com.tr.hesap-onay.xyz</em> adresinin sahibi hesap-onay.xyz’dir.</li>
                <li><strong>Gerçek adı yola koymak:</strong> <em>kampanya.top/mavibank.com.tr</em> adresinin sahibi kampanya.top’tur.</li>
                <li><strong>Benzer harfler kullanmak:</strong> <em>rnavibank.com.tr</em> adresinde m yerine yan yana r ve n var. Hızlı okurken göz bunu m sanır.</li>
                <li><strong>Kelime eklemek:</strong> <em>mavibank-guvenlik.com</em> tamamen farklı bir alan adıdır. Tire ile eklenen bir kelime, adresi bambaşka bir siteye çevirir.</li>
            </ul>
        </div>

        <x-callout title="İpucu: önemli işlerde bağlantıya tıklama" class="mt-8">
            Banka, e-Devlet ya da alışveriş gibi önemli işlerde mesajlardaki bağlantılara tıklamak yerine adresi kendin yaz ya da kurumun uygulamasını kullan.
            Özellikle <em>kisa.link/x7Ab</em> gibi kısaltılmış bağlantılara dikkat et: gerçek adresi tamamen gizlerler.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Alan adı avcısı">
        <div class="lesson">
            <p>
                Altı bağlantı göreceksin. Her birinde önce adresin sahibini gösteren parçaya tıkla, sonra bağlantının gerçekten
                Mavi Bank’a ait olup olmadığına karar ver. Mavi Bank’ın gerçek alan adı <strong>mavibank.com.tr</strong>.
            </p>
            <p class="text-muted text-base">Bu görevdeki tüm kurumlar ve adresler uydurmadır.</p>
        </div>

        <x-url-lab
            question="Bu bağlantı gerçekten Mavi Bank’a mı ait?"
            requirement="Alan adı avcısındaki tüm bağlantıları incele"
            class="mt-6"
        >
            <x-url-lab.address genuine :parts="[['https://', 'protocol'], ['www.', 'subdomain'], ['mavibank.com.tr', 'domain'], ['/giris', 'path']]">
                Alan adı tam olarak <strong class="font-bold">mavibank.com.tr</strong>. Baştaki “www.” sadece bir alt alan adı ve onu ancak
                alan adının sahibi, yani Mavi Bank ekleyebilir.
            </x-url-lab.address>

            <x-url-lab.address :parts="[['https://', 'protocol'], ['mavibank.com.tr.', 'subdomain'], ['hesap-onay.xyz', 'domain'], ['/giris', 'path']]">
                Adres “mavibank.com.tr” ile başlıyor ama bu sadece bir alt alan adı. İlk eğik çizgiden sola doğru okuyunca alan adının
                <strong class="font-bold">hesap-onay.xyz</strong> olduğunu görürsün. Bu site Mavi Bank’a değil, saldırgana ait.
            </x-url-lab.address>

            <x-url-lab.address :parts="[['http://', 'protocol'], ['kampanya-firsat.top', 'domain'], ['/mavibank.com.tr/giris', 'path']]">
                “mavibank.com.tr” bu kez yol kısmında, yani ilk eğik çizgiden sonra. Yola herkes istediğini yazabilir.
                Adresin sahibi <strong class="font-bold">kampanya-firsat.top</strong>.
            </x-url-lab.address>

            <x-url-lab.address genuine :parts="[['https://', 'protocol'], ['internet.', 'subdomain'], ['mavibank.com.tr', 'domain'], ['/hesaplarim', 'path']]">
                “internet.” bir alt alan adı. Alt alan adlarını yalnızca alan adının sahibi oluşturabildiği için bu adres gerçekten
                <strong class="font-bold">mavibank.com.tr</strong>’ye ait. Bankalar farklı hizmetler için böyle alt alan adları kullanır.
            </x-url-lab.address>

            <x-url-lab.address :parts="[['https://', 'protocol'], ['rnavibank.com.tr', 'domain'], ['/giris', 'path']]">
                Dikkatli bak: m değil, yan yana <strong class="font-bold">r ve n</strong> var: rnavibank. Hızlı okurken göz bunu m sanır.
                Tek harf farkı bile tamamen başka bir site demektir.
            </x-url-lab.address>

            <x-url-lab.address :parts="[['https://', 'protocol'], ['mavibank-guvenlik.com', 'domain'], ['/sifre-yenile', 'path']]">
                <strong class="font-bold">mavibank-guvenlik.com</strong> ile mavibank.com.tr arasında hiçbir bağ yok. Tire ile eklenen “guvenlik”
                kelimesi adresi bambaşka bir alan adına çeviriyor; üstelik uzantı da farklı.
            </x-url-lab.address>
        </x-url-lab>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="“odeme.kargotakip.com.tr.ucret-ode.top/odeme” adresi kime ait?">
                <x-quiz.option>kargotakip.com.tr</x-quiz.option>
                <x-quiz.option correct>ucret-ode.top</x-quiz.option>
                <x-quiz.option>odeme</x-quiz.option>

                <x-slot:explanation>
                    İlk eğik çizgiden önceki kısım “odeme.kargotakip.com.tr.ucret-ode.top”. Sağdan sola okuyunca alan adının
                    ucret-ode.top olduğunu görürsün; soldaki her şey saldırganın eklediği alt alan adı.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Adres çubuğunda kilit simgesi ve “https” görmek ne anlama gelir?">
                <x-quiz.option>Site devlet tarafından onaylanmıştır.</x-quiz.option>
                <x-quiz.option correct>Bağlantı şifrelidir, ama site yine de sahte olabilir.</x-quiz.option>
                <x-quiz.option>Site kesinlikle güvenlidir.</x-quiz.option>

                <x-slot:explanation>
                    Kilit simgesi sadece bilgilerinin yolda okunamayacağını gösterir. Oltalama sitelerinin çoğu da https kullanır.
                    Kime bağlandığını söyleyen şey alan adıdır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bu adreslerden hangisi gerçekten mavibank.com.tr’ye aittir?">
                <x-quiz.option>https://mavibank.com.tr.giris.net</x-quiz.option>
                <x-quiz.option correct>https://destek.mavibank.com.tr/yardim</x-quiz.option>
                <x-quiz.option>https://mavibank-com-tr.online</x-quiz.option>
                <x-quiz.option>https://giris.online/mavibank.com.tr</x-quiz.option>

                <x-slot:explanation>
                    “destek.” bir alt alan adı ve onu yalnızca mavibank.com.tr’nin sahibi oluşturabilir. Diğer adreslerin alan adları
                    sırasıyla giris.net, mavibank-com-tr.online ve giris.online.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
