<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'plan' => 'Planı kur', 'sina' => 'Sına']">
    <x-slot:intro>
        Bir sabah hesabına giremiyorsun, arkadaşların da senden tuhaf mesajlar aldıklarını söylüyor. Böyle bir anda panik, saldırganın en büyük
        yardımcısıdır. Bu görevde bir hesabın ele geçirildiğini nasıl anlayacağını öğrenecek, sonra hesabını geri almak için adım adım bir kriz planı kuracaksın.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Kapı zorlanmış mı?">
        <div class="lesson">
            <h3>Ele geçirilmiş bir hesabın belirtileri</h3>
            <ul>
                <li>Tanımadığın bir cihazdan ya da şehirden <strong>“yeni giriş”</strong> bildirimi.</li>
                <li>Sen hiçbir şey yapmadığın hâlde gelen “parolanız değiştirildi” ya da “kurtarma e-postanız değiştirildi” e-postaları.</li>
                <li>Senin istemediğin doğrulama kodları. Bu, birinin parolanı bildiği ve içeri girmeye çalıştığı anlamına gelir.</li>
                <li>Arkadaşlarına senin hesabından giden para isteyen ya da bağlantı içeren mesajlar.</li>
                <li>Gönderilenler klasöründe yazmadığın e-postalar, hesabında senin yapmadığın paylaşımlar.</li>
            </ul>

            <h3>Saldırgan içerideyken ne yapar?</h3>
            <p>Akıllı bir saldırgan kapıdan girince arkasından kilitleri değiştirir ve gizli kapılar bırakır:</p>
            <ul>
                <li>Parolanı, kurtarma e-postanı ve telefonunu değiştirir. Böylece “parolamı unuttum” düğmesi sana değil ona çalışır.</li>
                <li>E-postana gizli bir <strong>yönlendirme kuralı</strong> ekler: parolanı değiştirsen bile gelen her e-postanın bir kopyası ona gitmeye devam eder.</li>
                <li>Hesabına kendi uygulamasını bağlar ya da kendi cihazını “güvenilir cihaz” olarak ekler.</li>
                <li>Ele geçirdiği e-postayla diğer hesaplarının parolalarını sıfırlamaya çalışır.</li>
            </ul>
            <p>Bu yüzden hesabı geri almak tek başına yetmez; saldırganın arkasında bıraktığı bütün kapıları tek tek kapatman gerekir.</p>

            <h3>İlk saatin üç kuralı</h3>
            <ol>
                <li><strong>Sakin ol ve saldırganla konuşma.</strong> Pazarlık etmek ya da para teklif etmek hesabını geri getirmez.</li>
                <li>
                    <strong>Yalnızca resmi yolu kullan.</strong> Uygulamayı ya da siteyi kendin aç; “parolamı unuttum” ya da “hesabım ele geçirildi”
                    sayfasından ilerle. Kriz anında sana gelen “hesabınızı kurtarın” bağlantıları çoğu zaman yeni bir tuzaktır.
                </li>
                <li><strong>Mümkünse temiz bir cihaz kullan.</strong> Bilgisayarında zararlı yazılım varsa yeni parolanı da çalabilir.</li>
            </ol>
        </div>

        <x-callout tone="warning" title="Hesaba hiç giremiyorsan" class="mt-8">
            Saldırgan kurtarma e-postanı ve telefonunu da değiştirdiyse platformun resmi kurtarma formunu doldur. Çoğu platform, hesabın gerçek sahibi
            olduğunu göstermen için eski parolanı, hesabı açtığın yaklaşık tarihi ya da kimlik doğrulamasını sorar. Para kaybettiysen ya da şantaj
            varsa ekran görüntülerini sakla ve polise ya da savcılığa şikâyette bulun.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="plan" number="2" title="Kriz planını kur">
        <div class="lesson">
            <p>
                Sabah 07.40. Telefonuna art arda üç e-posta düştü: “Parolanız değiştirildi”, “Kurtarma telefonunuz güncellendi”,
                “Yeni bir cihazdan giriş yapıldı”. Kardeşin de az önce senin hesabından garip bir bağlantı aldığını yazdı.
            </p>
            <p>
                Hesabını geri almak için yapacaklarını sırayla seç. Aynı anda yapılabilecek adımlar istediğin sırada gelebilir. İki tuzağa dikkat!
            </p>
        </div>

        <x-response-plan requirement="Hesap kurtarma planını kur" class="mt-6">
            <x-response-plan.step trap>
                “Hesabınızı kurtarın” diye gelen e-postadaki bağlantıya tıkla.

                <x-slot:why>
                    Kriz anında gelen “kurtarma” bağlantıları en sevilen oltalama yemidir. Saldırgan senin panikte olduğunu bilir. Siteyi ya da uygulamayı her zaman kendin aç.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="3">
                Kurtarma e-postasını ve telefonu yeniden kendi bilgilerinle değiştir.

                <x-slot:why>
                    Saldırgan bunları kendi bilgileriyle değiştirmişti. Düzeltmezsen “parolamı unuttum” düğmesi ona çalışmaya devam eder.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="1">
                Uygulamayı kendin açıp resmi kurtarma sayfasından hesabına yeniden gir.

                <x-slot:why>
                    Her şey hesaba yeniden girmekle başlar. Resmi yol: uygulamanın kendisi ya da adresini kendin yazdığın site, “parolamı unuttum” ya da “hesabım ele geçirildi” sayfası.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="4">
                Arkadaşlarını uyar: “Hesabım ele geçirildi, benden gelen bağlantılara tıklamayın.”

                <x-slot:why>
                    Saldırgan senin adınla başkalarını da kandırmaya çalıştı. Uyarın, zincirin bir sonraki halkasını korur.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="2">
                Yeni, uzun ve başka hiçbir yerde kullanmadığın bir parola belirle.

                <x-slot:why>
                    İçeri girer girmez kilidi değiştir. Yeni parola eskisinin bir türevi olmasın: “Kale2023” yerine “Kale2024” yazarsan saldırgan onu da dener.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="3">
                Açık oturumların hepsinden çıkış yap.

                <x-slot:why>
                    Parolayı değiştirmek saldırganın zaten açık olan oturumunu her zaman kapatmaz. “Tüm cihazlardan çıkış yap” onu kapının dışına atar.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step trap>
                Saldırgana yazıp hesabını geri vermesi için para teklif et.

                <x-slot:why>
                    Pazarlık, saldırgana ne kadar çaresiz olduğunu gösterir. Parayı alsa bile hesabı geri vereceğinin hiçbir garantisi yoktur; çoğu zaman daha fazlasını ister.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="3">
                E-postadaki yönlendirme kurallarını ve hesaba bağlı uygulamaları temizle.

                <x-slot:why>
                    Bunlar saldırganın bıraktığı arka kapılar. Gizli bir yönlendirme kuralı, yeni parolana rağmen e-postalarının kopyasını ona göndermeye devam eder.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="3">
                İki adımlı doğrulamayı aç.

                <x-slot:why>
                    Parolan bir daha çalınsa bile kapının ikinci kilidi saldırganı durdurur. Saldırganın eklediği bir doğrulama cihazı ya da numarası varsa onu da sil.
                </x-slot:why>
            </x-response-plan.step>

            <x-response-plan.step stage="4">
                Aynı parolayı kullandığın diğer hesapların parolalarını da değiştir.

                <x-slot:why>
                    Saldırgan çaldığı parolayı başka sitelerde de dener. Aynı parolayı kullanan her hesap aynı tehlikededir.
                </x-slot:why>
            </x-response-plan.step>

            <x-slot:summary>
                Önce içeri gir, sonra kilidi değiştir, ardından saldırganın bıraktığı bütün arka kapıları kapat ve en son etrafındakileri koru.
                Bu sırayı bir kâğıda yazıp sakla: kriz anında düşünmek zordur, hazır bir plan ise düşünmeden uygulanır.
            </x-slot:summary>
        </x-response-plan>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Parolanı değiştirdin ama saldırgan hâlâ e-postalarını okuyor gibi. En olası neden ne?">
                <x-quiz.option>Parolayı yanlış değiştirdim.</x-quiz.option>
                <x-quiz.option correct>Saldırgan bir yönlendirme kuralı eklemiş ya da açık oturumu hâlâ kapanmamış.</x-quiz.option>
                <x-quiz.option>E-posta hesapları zaten herkese açıktır.</x-quiz.option>

                <x-slot:explanation>
                    Saldırganlar içerideyken arka kapı bırakır. Yönlendirme kurallarını, bağlı uygulamaları ve açık oturumları temizlemeden
                    yalnızca parolayı değiştirmek, kapının kilidini değiştirip arka pencereyi açık bırakmak gibidir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Hesabın ele geçirildikten hemen sonra “Hesabınızı kurtarmak için tıklayın” diye bir e-posta geldi. Ne yaparsın?">
                <x-quiz.option>Hemen tıklarım; her dakika önemli.</x-quiz.option>
                <x-quiz.option>Gönderenin adı doğru görünüyorsa tıklarım.</x-quiz.option>
                <x-quiz.option correct>Tıklamam; uygulamayı ya da siteyi kendim açıp oradan ilerlerim.</x-quiz.option>

                <x-slot:explanation>
                    Gönderen adı kolayca taklit edilir. Kriz anında hızlı davranmak önemli, ama doğru kapıdan: resmi uygulama ya da adresini kendin yazdığın site.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Kriz planında ilk adım hangisi olmalı?">
                <x-quiz.option correct>Resmi yoldan hesaba yeniden girmek.</x-quiz.option>
                <x-quiz.option>Hesabı tamamen silmek.</x-quiz.option>
                <x-quiz.option>Saldırgana yazıp ne istediğini sormak.</x-quiz.option>

                <x-slot:explanation>
                    Kapının anahtarını geri almadan kilitleri değiştiremezsin. Hesabı silmek ise içindeki her şeyi kaybetmek demektir ve saldırganın
                    açtığı diğer kapıları kapatmaz. Hesaba hiç giremiyorsan arkadaşlarını başka bir yoldan hemen uyar.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
