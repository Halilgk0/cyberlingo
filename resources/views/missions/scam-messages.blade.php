<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Dene', 'sina' => 'Sına']">
    <x-slot:intro>
        Dolandırıcıların çoğu bir bilgisayara sızmaya uğraşmaz; bir mesaj ya da bir telefon onlara yeter.
        Bu görevde insanları kandırmak için kullanılan hileleri öğrenecek, sonra iki sahte mesajlaşmada doğru yanıtları seçeceksin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Sosyal mühendislik nedir?">
        <div class="lesson">
            <p>
                <strong>Sosyal mühendislik</strong>, bir bilgisayarı değil bir insanı kandırarak bilgi, para ya da erişim elde etmektir.
                Dolandırıcı teknik bir açık aramak yerine güvendiğin biri gibi görünür: bir aile üyen, bankan, telefon operatörün, hatta polis.
            </p>

            <h3>Kullandıkları dört duygu</h3>
            <ul>
                <li><strong>Korku:</strong> “Adınız bir soruşturmada geçiyor”, “Hattınız kapatılacak”. Korkan insan sorgulamadan söyleneni yapar.</li>
                <li><strong>Aciliyet:</strong> “10 dakika içinde”, “Hemen şimdi”. Amaç, düşünmene ve birine danışmana fırsat vermemek.</li>
                <li><strong>Sevgi ve güven:</strong> “Anne, telefonum bozuldu, bu yeni numaram.” Sevdiğin birine yardım etme isteğini kullanır.</li>
                <li><strong>Fırsat:</strong> “Hediye internet”, “Ayda yüzde 40 kazandıran yatırım”. Gerçek olamayacak kadar iyi teklifler.</li>
            </ul>

            <h3>Seni koruyacak dört kural</h3>
            <ol>
                <li><strong>Doğrulama kodunu kimseyle paylaşma.</strong> SMS ile gelen tek kullanımlık kodu bankan, operatörün, kargo şirketi ya da polis asla istemez. Bu kodu isteyen herkes dolandırıcıdır.</li>
                <li><strong>Yeni numaradan para isteyen tanıdığını doğrula.</strong> Onu bildiğin eski numarasından ara ya da sadece ikinizin bilebileceği bir şey sor.</li>
                <li><strong>Resmi kurumlar telefonda para istemez.</strong> Polis, savcı ya da banka çalışanı “paranızı güvenceye alalım” diyerek para transferi, altın ya da nakit istemez.</li>
                <li><strong>Acele ettiriliyorsan dur.</strong> Telefonu kapatmak ve mesajı yanıtsız bırakmak her zaman senin hakkın.</li>
            </ol>
        </div>

        <x-callout title="Şüphelendiysen ne yapmalısın?" class="mt-8">
            Konuşmayı bitir ve numarayı engelle. Kuruma kendi bildiğin yoldan ulaş: kartının arkasındaki numara, resmi uygulama ya da web sitesi.
            Para gönderdiysen ya da bir kod paylaştıysan vakit kaybetmeden bankanı ara.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Mesajlara yanıt ver">
        <div class="lesson">
            <p>
                Aşağıda iki mesajlaşma var. Gelen mesajları oku ve her seferinde vereceğin yanıtı seç.
                Riskli bir yanıt seçersen nedenini görecek ve tekrar deneyebileceksin.
            </p>
            <p class="text-muted text-base">Bu görevdeki tüm kişiler, kurumlar ve numaralar uydurmadır.</p>
        </div>

        <h3 class="font-display mt-10 text-2xl leading-tight font-extrabold tracking-tight">Sohbet 1: “Numaram değişti”</h3>
        <x-chat contact="Bilinmeyen numara" detail="+90 5•• ••• •• 47" avatar="?" requirement="Birinci sohbeti tamamla" class="mt-4">
            <x-chat.turn>
                <x-slot:messages>
                    <x-chat.message>Anneciğim merhaba, benim Elif 😊 Telefonum suya düştü, bu yeni numaram.</x-chat.message>
                    <x-chat.message>Bir şey rica edeceğim. Acil 4.750 TL ödemem var ama bankam açılmıyor. Şu IBAN’a atabilir misin? Akşam geri veririm 🙏</x-chat.message>
                </x-slot:messages>

                <x-chat.reply>
                    Tabii kızım, hemen gönderiyorum.

                    <x-slot:feedback>
                        Bu, dolandırıcıların en sık kullandığı senaryolardan biri: “numaram değişti, acil para lazım”.
                        Gönderdiğin parayı geri almak neredeyse imkânsızdır.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply safe>
                    Önce Elif’in eski numarasını arayıp kontrol edeceğim.

                    <x-slot:feedback>
                        Yeni bir numaradan para isteyen birini her zaman bildiğin eski yoldan doğrula: eski numarası ya da ortak bir tanıdık.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply>
                    Gerçekten sen misin? Bir fotoğrafını at.

                    <x-slot:feedback>
                        Fotoğrafını sosyal medyadan kolayca bulabilir. Fotoğraf, profil resmi ya da isim kimlik kanıtı sayılmaz.
                    </x-slot:feedback>
                </x-chat.reply>
            </x-chat.turn>

            <x-chat.turn>
                <x-slot:messages>
                    <x-chat.message>Anne arama, eski telefonum bozuk dedim ya, açılmıyor 😢</x-chat.message>
                    <x-chat.message>Lütfen çok acil, 10 dakika içinde ödemezsem cezaya giriyorum!</x-chat.message>
                </x-slot:messages>

                <x-chat.reply>
                    Peki, şimdilik sadece yarısını göndereyim.

                    <x-slot:feedback>
                        “10 dakika içinde” bir baskı tekniği. Küçük bir miktar göndermek de dolandırıcıya istediğini verir; üstelik daha fazlasını istemeye devam eder.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply>
                    Banka kartımın bilgilerini vereyim, ödemeyi sen yap.

                    <x-slot:feedback>
                        Kart numarasını, son kullanma tarihini ve arkasındaki kodu asla paylaşma. Bu, dolandırıcıya istediği kadar harcama yapma imkânı verir.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply safe>
                    Elif’sen söyle: geçen bayram dedemlere giderken arabanın neresi bozulmuştu?

                    <x-slot:feedback>
                        Sadece ikinizin bilebileceği bir soru dolandırıcıyı hemen ele verir. Yanıt veremezse konuşmayı bitir.
                    </x-slot:feedback>
                </x-chat.reply>
            </x-chat.turn>

            <x-chat.turn>
                <x-slot:messages>
                    <x-chat.message>Anne ne alakası var şimdi bunun 😡</x-chat.message>
                    <x-chat.message>Neyse boş ver, başkasından isterim.</x-chat.message>
                </x-slot:messages>
            </x-chat.turn>

            <x-slot:outcome>
                Dolandırıcı soruyu yanıtlayamadı ve vazgeçti. Elif’i eski numarasından aradığında telefonunun gayet sağlam olduğunu, sana hiç yazmadığını öğrendin.
                Bu numarayı engelle ve şikâyet et: aynı kişi başkalarını da deneyecektir.
            </x-slot:outcome>
        </x-chat>

        <h3 class="font-display mt-14 text-2xl leading-tight font-extrabold tracking-tight">Sohbet 2: “Hediye internet”</h3>
        <x-chat contact="Turkuaz Mobil Destek" detail="+90 850 ••• •• 12" requirement="İkinci sohbeti tamamla" class="mt-4">
            <x-chat.turn>
                <x-slot:messages>
                    <x-chat.message>Merhaba, Turkuaz Mobil müşteri hizmetlerinden yazıyoruz. Hattınıza 50 GB hediye internet tanımlanacak 🎁</x-chat.message>
                    <x-chat.notice from="Mavi Bank">
                        482913 kodu ile yeni bir cihazdan internet şubenize giriş yapılıyor. Bu kodu kimseyle paylaşmayın. İşlem size ait değilse bizi arayın.
                    </x-chat.notice>
                    <x-chat.message>Tanımlama için telefonunuza 6 haneli bir kod gönderdik. Kodu buraya yazar mısınız?</x-chat.message>
                </x-slot:messages>

                <x-chat.reply>
                    482913

                    <x-slot:feedback>
                        SMS’i dikkatli oku: bu kod hediye internet için değil, Mavi Bank hesabına yeni bir cihazdan giriş için!
                        Kodu verirsen dolandırıcı hesabına girer. SMS’in kendisi bile “kimseyle paylaşmayın” diyor.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply>
                    Önce kimliğinizi kanıtlayın, sonra kodu veririm.

                    <x-slot:feedback>
                        Dolandırıcı inandırıcı bir isim, sicil numarası ya da belge uydurabilir. Karşındaki kim olursa olsun doğrulama kodu paylaşılmaz.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply safe>
                    Kodu kimseyle paylaşmam. Bir işlem varsa uygulamanızdan kendim bakarım.

                    <x-slot:feedback>
                        Doğrulama kodu sadece senin içindir. Hiçbir kurum bu kodu senden istemez; isteyen kişi dolandırıcıdır.
                    </x-slot:feedback>
                </x-chat.reply>
            </x-chat.turn>

            <x-chat.turn>
                <x-slot:messages>
                    <x-chat.message>Kodu iletmezseniz hattınız 1 saat içinde kapatılacaktır!</x-chat.message>
                </x-slot:messages>

                <x-chat.reply>
                    Tamam tamam, kodu gönderiyorum.

                    <x-slot:feedback>
                        Tehdit, panik yaptırıp düşünmeni engellemek için. Gerçek bir operatör hattını bir kod yüzünden kapatmakla tehdit etmez.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply>
                    Neden kapansın ki? Anlamadım, biraz daha açıklar mısınız?

                    <x-slot:feedback>
                        Konuşmayı uzatmak, dolandırıcıya seni ikna etmek için daha çok fırsat verir. Şüphelendiğin anda konuşmayı bitir.
                    </x-slot:feedback>
                </x-chat.reply>

                <x-chat.reply safe>
                    Konuşmayı burada bitiriyorum. Bankamı resmi numarasından arayıp haber vereceğim.

                    <x-slot:feedback>
                        Konuşmayı bitirmek her zaman senin hakkın. Bankanı kartının arkasındaki numaradan ya da uygulamasından aramak en doğrusu.
                    </x-slot:feedback>
                </x-chat.reply>
            </x-chat.turn>

            <x-slot:outcome>
                Kodu vermediğin için dolandırıcı hesabına giremedi. Ama dikkat: bu kodun sana gelmesi, birinin Mavi Bank parolanı bildiği anlamına gelir.
                Hemen parolanı değiştir ve bankana haber ver. İki adımlı doğrulama seni ancak kodu kimseyle paylaşmadığında korur.
            </x-slot:outcome>
        </x-chat>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="SMS ile gelen bir doğrulama kodunu kimlerle paylaşabilirsin?">
                <x-quiz.option>Sadece bankamla.</x-quiz.option>
                <x-quiz.option>Sadece polisle.</x-quiz.option>
                <x-quiz.option>Telefon operatörümle.</x-quiz.option>
                <x-quiz.option correct>Hiç kimseyle.</x-quiz.option>

                <x-slot:explanation>
                    Doğrulama kodu, hesabına girenin gerçekten sen olduğunu kanıtlar. Bu yüzden onu isteyen herkes, kim olduğunu söylerse söylesin, dolandırıcıdır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Polis olduğunu söyleyen biri arıyor ve “paranızı güvenceye almak için” başka bir hesaba aktarmanızı istiyor. Ne yapmalısın?">
                <x-quiz.option>Söyleneni yaparım; polisle tartışmamak gerekir.</x-quiz.option>
                <x-quiz.option>Önce kimlik numarasını sorarım, doğru söylerse aktarırım.</x-quiz.option>
                <x-quiz.option correct>Telefonu kapatırım; gerçekten bir sorun varsa resmi numaralardan kendim ararım.</x-quiz.option>

                <x-slot:explanation>
                    Polis, savcı ya da hiçbir resmi kurum telefonda para transferi istemez. Arayan kişinin bildiği bilgiler (adın, adresin) seni yanıltmasın;
                    bunlar sızıntılardan kolayca bulunabilir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Sosyal mühendislik nedir?">
                <x-quiz.option>Sosyal medya hesaplarını yöneten bir mühendislik dalı.</x-quiz.option>
                <x-quiz.option correct>Bir insanı kandırarak ondan bilgi, para ya da erişim elde etmek.</x-quiz.option>
                <x-quiz.option>Bilgisayar virüslerini temizleme yöntemi.</x-quiz.option>

                <x-slot:explanation>
                    Sosyal mühendislik teknolojiyi değil insanı hedef alır. En güçlü parola bile, kodu kendi elinle verirsen seni koruyamaz.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
