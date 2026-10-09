<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'avla' => 'İzleri bul', 'mudahale' => 'Müdahale et']">
    <x-slot:intro>
        Saldırganlar sessiz olmaya çalışır, ama her adımları bir yerde iz bırakır: sistemlerin tuttuğu kayıtlarda. Savunma ekipleri bu kayıtları
        okuyarak saldırıyı yakalar. Bu görevde bir kitabevinin e-posta kayıtlarını bir analist gibi okuyacak, süzecek ve bir saldırının izini süreceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Kayıtlar ne anlatır?">
        <div class="lesson">
            <p>
                <strong>Kayıt</strong> (log), bir sistemin olup biteni yazdığı günlüktür. Her satır kısa bir hikâye anlatır: <strong>ne zaman</strong>,
                <strong>nereden</strong> (IP adresi), <strong>kim</strong> (kullanıcı), <strong>ne yaptı</strong> ve <strong>sonuç</strong>.
                Kurumlarda bu kayıtları izleyen ekiplere mavi takım ya da güvenlik operasyon merkezi (SOC) denir.
            </p>
        </div>

        <div class="terminal mt-6">
            <p class="text-muted"># Bir giriş kaydı satırı</p>
            <p class="mt-2 break-words"><span class="text-muted">09:03:40</span>&nbsp;&nbsp;<span class="text-rune">203.0.113.77</span>&nbsp;&nbsp;<span class="text-signal">zeynep</span>&nbsp;&nbsp;giriş başarısız: yanlış parola</p>
            <ul class="mt-4 flex flex-col gap-1 text-xs sm:text-sm">
                <li><span class="text-muted">09:03:40</span> ne zaman oldu</li>
                <li><span class="text-rune">203.0.113.77</span> isteğin geldiği IP adresi</li>
                <li><span class="text-signal">zeynep</span> hangi hesap için</li>
                <li>giriş başarısız: ne oldu</li>
            </ul>
        </div>

        <div class="lesson mt-10">
            <h3>Şüpheli kalıplar</h3>
            <ul>
                <li><strong>Art arda başarısızlık:</strong> Aynı adresten saniyeler içinde gelen çok sayıda yanlış parola, bir tahmin saldırısıdır.</li>
                <li><strong>Parola püskürtme:</strong> Tek bir adresin çok sayıda farklı hesabı, her birinde birkaç yaygın parolayla denemesi.</li>
                <li><strong>Başarısızlıkların ardından başarı:</strong> Denemelerin hemen sonundaki başarılı giriş, saldırının en kritik anıdır.</li>
                <li><strong>İmkânsız yolculuk:</strong> Aynı hesaba on dakika arayla iki farklı ülkeden giriş yapılması.</li>
                <li><strong>Girişten hemen sonra ayar değişikliği:</strong> Yeni bir yönlendirme kuralı, değişen kurtarma bilgileri ya da parola. Hesap kurtarma görevini hatırla: saldırgan içeri girince kilitleri değiştirir.</li>
            </ul>

            <h3>Her başarısızlık saldırı değildir</h3>
            <p>
                İnsanlar parolalarını yanlış yazar. Tek bir başarısız deneme ve hemen ardından gelen başarılı giriş çoğu zaman bir yazım hatasıdır.
                Analistin işi tek tek satırlara değil, kalıplara bakmaktır. Bunun için de binlerce satırı tek tek okumaz, <strong>süzer</strong>: bir IP adresine,
                bir kullanıcıya ya da bir olaya göre.
            </p>
        </div>

        <x-callout title="Bu görevdeki adresler" class="mt-8">
            Kayıtlardaki IP adresleri, belgelerde örnek olarak kullanılmak üzere ayrılmış adreslerdir; gerçek bir kişiye ya da kuruma ait değildir.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="avla" number="2" title="Saldırının izlerini bul">
        <div class="lesson">
            <p>
                Pazartesi sabahı Kale Kitabevi’nin e-posta sisteminden bir uyarı geldi. Kayıtları incele ve saldırının dört izini bul.
                Bir satıra dokunduğunda ne anlama geldiğini göreceksin. İpucu: süzme kutusuna şüphelendiğin bir IP adresini yaz.
            </p>
        </div>

        <x-log-hunt requirement="Saldırının dört izini bul" class="mt-6">
            <x-log-hunt.line time="08:58:02" ip="192.0.2.14" user="ayse" why="Ofisin ağından, mesai başında tek bir başarılı giriş. Olağan.">giriş başarılı</x-log-hunt.line>
            <x-log-hunt.line time="09:01:15" ip="192.0.2.21" user="mehmet" why="Mehmet de ofisten giriş yapıyor. Olağan.">giriş başarılı</x-log-hunt.line>
            <x-log-hunt.line time="09:03:40" ip="203.0.113.77" user="zeynep" evidence="tahmin">giriş başarısız: yanlış parola</x-log-hunt.line>
            <x-log-hunt.line time="09:03:41" ip="203.0.113.77" user="zeynep" evidence="tahmin">giriş başarısız: yanlış parola</x-log-hunt.line>
            <x-log-hunt.line time="09:03:41" ip="203.0.113.77" user="zeynep" evidence="tahmin">giriş başarısız: yanlış parola</x-log-hunt.line>
            <x-log-hunt.line time="09:03:42" ip="203.0.113.77" user="zeynep" evidence="tahmin">giriş başarısız: yanlış parola</x-log-hunt.line>
            <x-log-hunt.line time="09:03:43" ip="203.0.113.77" user="zeynep" evidence="tahmin">giriş başarısız: yanlış parola</x-log-hunt.line>
            <x-log-hunt.line time="09:05:20" ip="198.51.100.23" user="can" why="Tek bir yanlış parola ve birkaç saniye sonra başarılı giriş: Can evden çalışıyor ve büyük ihtimalle parolasını yanlış yazdı. Her başarısızlık saldırı değildir.">giriş başarısız: yanlış parola</x-log-hunt.line>
            <x-log-hunt.line time="09:05:31" ip="198.51.100.23" user="can" why="Can’ın yazım hatasından hemen sonraki başarılı girişi. Olağan.">giriş başarılı</x-log-hunt.line>
            <x-log-hunt.line time="09:06:02" ip="203.0.113.77" user="zeynep" evidence="giris">giriş başarılı</x-log-hunt.line>
            <x-log-hunt.line time="09:06:40" ip="203.0.113.77" user="zeynep" evidence="yonlendirme">yönlendirme kuralı eklendi: tüm postalar → kargo.takip@posta.example</x-log-hunt.line>
            <x-log-hunt.line time="09:07:15" ip="203.0.113.77" user="zeynep" evidence="kilit">kurtarma telefonu değiştirildi</x-log-hunt.line>
            <x-log-hunt.line time="09:07:48" ip="203.0.113.77" user="zeynep" evidence="kilit">parola değiştirildi</x-log-hunt.line>
            <x-log-hunt.line time="09:10:00" ip="192.0.2.14" user="ayse" why="Ayşe ofisten bir rapor indiriyor. Olağan bir iş.">dosya indirildi: kasim-raporu.pdf</x-log-hunt.line>
            <x-log-hunt.line time="09:20:05" ip="192.0.2.21" user="mehmet" why="Mehmet oturumunu kapatıyor. Olağan.">çıkış yapıldı</x-log-hunt.line>

            <x-slot:evidence>
                <template data-evidence-why="tahmin">
                    Aynı yabancı adresten, saniyeler içinde art arda yanlış parola: bu bir parola tahmin saldırısı. 203.0.113.77 ofisin adresi değil.
                </template>
                <template data-evidence-why="giris">
                    Başarısız denemelerin hemen ardından aynı adresten başarılı giriş: saldırgan parolayı tahmin etti. Saldırının en kritik anı bu satır.
                </template>
                <template data-evidence-why="yonlendirme">
                    İçeri giren saldırganın ilk işi bir arka kapı açmak: Zeynep’e gelen bütün e-postaların kopyası artık başka bir adrese gidiyor.
                </template>
                <template data-evidence-why="kilit">
                    Saldırgan kilitleri değiştiriyor: kurtarma telefonu ve parola artık onun. Gerçek Zeynep bundan sonra hesabına giremez.
                </template>
            </x-slot:evidence>

            <x-slot:summary>
                Tahmin, başarılı giriş, arka kapı ve kilitlerin değişmesi: hepsi tek bir adresten, beş dakika içinde. Gerçek bir sistemde bu satırlar
                binlerce olağan satırın arasında olurdu; süzmek ve kalıbı görmek bu yüzden analistin en önemli becerisidir.
            </x-slot:summary>
        </x-log-hunt>
    </x-mission.step>

    <x-mission.step id="mudahale" number="3" title="Müdahale et">
        <x-quiz>
            <x-quiz.question prompt="Zeynep’in hesabı için ilk ne yapılmalı?">
                <x-quiz.option>Zeynep’e yeni parolasını e-postayla göndermek.</x-quiz.option>
                <x-quiz.option correct>Hesabın bütün oturumlarını kapatmak; parolayı ve kurtarma telefonunu sıfırlamak, yönlendirme kuralını silmek.</x-quiz.option>
                <x-quiz.option>Kayıtları silip temiz bir sayfa açmak.</x-quiz.option>

                <x-slot:explanation>
                    E-posta hesabı zaten saldırganın elinde, oraya parola göndermek onu saldırgana vermek olur. Kayıtları silmek ise kanıtı yok eder.
                    Önce saldırganı dışarı atıp bıraktığı arka kapıları kapatmak gerekir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="203.0.113.77 adresi için ne yapılmalı?">
                <x-quiz.option correct>Adresi engellemek ve diğer hesaplarda aynı adresten deneme olup olmadığına bakmak.</x-quiz.option>
                <x-quiz.option>Bu adrese karşı saldırı yapıp saldırganın bilgisayarına girmek.</x-quiz.option>
                <x-quiz.option>Hiçbir şey; saldırgan zaten içeri girdi.</x-quiz.option>

                <x-slot:explanation>
                    Savunucu kendi kapısını kapatır ve başka kapıların zorlanıp zorlanmadığına bakar. Karşı saldırı yapmak, saldırıya uğramış olsan bile
                    izinsiz giriştir ve suçtur; bu iş polisin ve savcılığındır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Böyle bir saldırının bir daha başarılı olmaması için en etkili önlem hangisi?">
                <x-quiz.option>Parolaları her hafta değiştirmek.</x-quiz.option>
                <x-quiz.option>Kayıt tutmayı bırakmak.</x-quiz.option>
                <x-quiz.option correct>Herkese iki adımlı doğrulama açmak ve art arda yanlış denemelerde girişi geçici olarak kısıtlamak.</x-quiz.option>

                <x-slot:explanation>
                    Parola tahmin edilse bile iki adımlı doğrulama saldırganı durdurur. Art arda denemeleri kısıtlamak da tahmini yavaşlatır:
                    CyberLingo da üst üste beş hatalı girişten sonra girişi kısa bir süre kısıtlar.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
