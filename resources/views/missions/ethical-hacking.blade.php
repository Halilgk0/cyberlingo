<x-layouts.mission :mission="$mission" :steps="['ogren' => 'Öğren', 'dene' => 'Şapkaları ayır', 'sina' => 'Sına']">
    <x-slot:intro>
        Bir kaleyi en iyi, ona nasıl saldırılacağını bilen biri savunur. Etik hackerlar da saldırganlar gibi düşünür, ama bunu yalnızca izin alarak
        ve savunmak için yapar. Bu görevde beyaz, gri ve siyah şapkalı hackerları ayıran çizgiyi öğreneceksin. O çizginin adı: izin.
    </x-slot:intro>

    <x-mission.step id="ogren" number="1" title="Üç şapka, tek çizgi">
        <div class="lesson">
            <p>
                <strong>Hacker</strong> kelimesi aslında kötü bir anlam taşımaz; bir sistemin nasıl çalıştığını en ince ayrıntısına kadar merak eden kişi demektir.
                Bu merakı nasıl kullandıklarına göre, eski kovboy filmlerindeki iyi ve kötü karakterlerin şapka renklerinden gelen bir benzetmeyle üçe ayrılırlar.
            </p>
        </div>

        <ul class="mt-6 grid gap-3 sm:grid-cols-3">
            @foreach ([
                ['🤍', 'Beyaz şapka', 'İzin alır, kurallara uyar. Bir kurumun isteğiyle sistemlerini test eder ve bulduğu açıkları yalnızca o kuruma bildirir.'],
                ['🩶', 'Gri şapka', 'Niyeti çoğu zaman iyidir, ama izin almadan dener. Bulduğu açığı haber verse bile izinsiz girdiği için yaptığı suç sayılabilir.'],
                ['🖤', 'Siyah şapka', 'Zarar vermek ya da kazanç sağlamak için izinsiz girer: veri çalar, satar, şantaj yapar.'],
            ] as [$emoji, $hat, $description])
                <li class="bg-card border-line rounded-2xl border-2 p-4 sm:p-5">
                    <span aria-hidden="true" class="text-3xl">{{ $emoji }}</span>
                    <span class="font-display mt-2 block text-2xl leading-tight font-extrabold">{{ $hat }}</span>
                    <span class="text-muted mt-1 block leading-relaxed">{{ $description }}</span>
                </li>
            @endforeach
        </ul>

        <div class="lesson mt-10">
            <h3>Çizgi neden izin?</h3>
            <p>
                Türk Ceza Kanunu’nun 243. maddesi, bir bilişim sistemine hukuka aykırı olarak girmeyi ya da orada kalmayı suç sayar. Kanun “niyetin iyi miydi?”
                diye sormaz; “izin var mıydı?” diye sorar. Bu yüzden gri şapka “iyi bir hacker” değil, iyi niyetli ama kuralı çiğneyen biridir.
                Pek çok ülkede de durum aynıdır.
            </p>

            <h3>Etik hackerın dört kuralı</h3>
            <ol>
                <li><strong>Önce yazılı izin.</strong> Sistemin sahibinden, neyin test edileceğini ve ne zaman yapılacağını yazan bir izin alınır.</li>
                <li><strong>Kapsamın dışına çıkma.</strong> İzin yalnızca belirtilen sistemler içindir; “yanındaki sunucuya da bir bakayım” denmez.</li>
                <li><strong>Zarar verme, veriye dokunma.</strong> Amaç açığı göstermektir; kişisel verileri kopyalamak, silmek ya da değiştirmek değil.</li>
                <li><strong>Yalnızca sahibine bildir.</strong> Bulgular gizli tutulur ve açık kapanmadan kimseyle paylaşılmaz.</li>
            </ol>

            <h3>Bu işin meslek hâli</h3>
            <ul>
                <li><strong>Sızma testi uzmanı:</strong> Kurumların isteğiyle, sözleşmeyle ve belirlenen kapsamda gerçek bir saldırganın yapabileceklerini dener, rapor yazar.</li>
                <li><strong>Hata ödül avcısı:</strong> Şirketlerin herkese açık “hata ödül” programlarına katılır; programın kurallarına uyarak bulduğu açıkları bildirir ve ödül alır.</li>
                <li><strong>Güvenlik analisti:</strong> Kurumun içinde saldırıları izler, açıkları kapatır, ekipleri eğitir.</li>
            </ul>
        </div>

        <x-callout title="Pratik yapmak istersen, yasal yolu seç" class="mt-8">
            Etik hack öğrenmenin yasal yolları var: kendi bilgisayarında kurduğun eğitim laboratuvarları, bilerek açıklı bırakılmış eğitim siteleri ve
            <strong class="font-bold">CTF</strong> (bayrağı yakala) yarışmaları. Bunlar tam olarak denenmek için yapılmıştır. Okulunun, arkadaşının ya da
            rastgele bir sitenin sistemlerini “deneme” için kullanmak ise izinsiz girişin ta kendisidir.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="dene" number="2" title="Kim hangi şapkayı taktı?">
        <div class="lesson">
            <p>Altı olayı oku ve her birinde kişinin beyaz, gri ya da siyah şapkalı olduğuna karar ver.</p>
            <p class="text-muted text-base">Olaylardaki kişiler ve kurumlar uydurmadır.</p>
        </div>

        <x-sorter
            :categories="['beyaz' => 'Beyaz şapka', 'gri' => 'Gri şapka', 'siyah' => 'Siyah şapka']"
            question="Bu kişi hangi şapkayı takıyor?"
            requirement="Altı olayda şapkaları ayır"
            class="mt-6"
        >
            <x-sorter.card answer="beyaz" label="İzinli banka testi">
                Mavi Bank’ın yazılı izniyle, sözleşmede yazan sistemleri test eden ve bulduklarını yalnızca bankaya rapor eden bir güvenlik uzmanı.

                <x-slot:explanation>
                    Yazılı izin, belirli bir kapsam ve bulguların yalnızca sahibine bildirilmesi: beyaz şapkanın üç işareti bir arada.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="gri" label="İzinsiz ama iyi niyetli">
                Bir alışveriş sitesinde izinsiz denemeler yaparak bir açık bulan, hiçbir veriye dokunmadan site sahibine e-postayla haber veren biri.

                <x-slot:explanation>
                    Niyeti iyi, zarar da vermemiş; ama denemeleri izinsiz yaptı. Bu yüzden gri şapka ve yaptığı suç sayılabilir. Doğrusu, önce sitenin
                    hata ödül programına ya da güvenlik bildirim sayfasına bakmaktı.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="siyah" label="Müşteri listesi satışı">
                Bir mağazanın sistemine sızıp müşteri bilgilerini kopyalayan ve internette satan biri.

                <x-slot:explanation>
                    İzinsiz giriş, veri hırsızlığı ve kazanç amacı. Bu, siyah şapkanın tanımıdır ve ağır bir suçtur.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="beyaz" label="Hata ödül programı">
                Bir uygulamanın hata ödül programının kurallarını okuyan, yalnızca kapsamdaki adreslerde deneme yapan ve bulduğunu programa bildiren bir öğrenci.

                <x-slot:explanation>
                    Hata ödül programı, şirketin önceden verdiği bir izindir. Kurallara ve kapsama uyduğu sürece yaptığı beyaz şapkalı bir iştir.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="gri" label="Okul sistemine izinsiz deneme">
                Okulunun not sistemini izinsiz kurcalayan, bir açık bulunca da notlara dokunmadan yönetime “Bunu düzeltin” diye yazan bir öğrenci.

                <x-slot:explanation>
                    İyi niyetli olsa da izin almadan denedi. Bu, hem okulda disiplin hem de hukuki bir soruna dönüşebilir. Bir açıktan şüphelenseydi, denemeden
                    bir öğretmene ya da bilgi işlem birimine anlatmalıydı.
                </x-slot:explanation>
            </x-sorter.card>

            <x-sorter.card answer="siyah" label="“Para verin, yoksa yayınlarım”">
                Bir şirkette açık bulan ve şirkete “Para vermezseniz açığı herkese yayınlarım” diye yazan biri.

                <x-slot:explanation>
                    Bulunan açığı para koparmak için kullanmak şantajdır. Hata ödül programındaki ödülle karıştırılmamalı: ödülü şirket kendi kurallarıyla
                    verir, kimse zorla istemez.
                </x-slot:explanation>
            </x-sorter.card>

            <x-slot:summary>
                Şapkanın rengini niyet değil izin belirler. Bir açığı merak ettiğinde ilk sorman gereken soru “Bunu denemeye iznim var mı?” olmalı.
            </x-slot:summary>
        </x-sorter>
    </x-mission.step>

    <x-mission.step id="sina" number="3" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Etik hackerı diğerlerinden ayıran en önemli şey nedir?">
                <x-quiz.option>Daha çok programlama dili bilmesi.</x-quiz.option>
                <x-quiz.option correct>Sistemin sahibinden önceden izin alması ve kapsamın dışına çıkmaması.</x-quiz.option>
                <x-quiz.option>Bulduğu açıkları internette paylaşması.</x-quiz.option>

                <x-slot:explanation>
                    Etik hacker ile saldırgan aynı bilgiye sahip olabilir. Aradaki fark izin, kapsam ve bulguları yalnızca sahibine bildirmektir.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Gri şapkalı biri hiçbir zarar vermeden bir açığı bulup haber verdi. Yaptığı yasal mıdır?">
                <x-quiz.option>Evet, zarar vermediği sürece sorun yok.</x-quiz.option>
                <x-quiz.option correct>Hayır, izinsiz giriş niyetten bağımsız olarak suç sayılabilir.</x-quiz.option>
                <x-quiz.option>Evet, açığı bildirdiği için ödül alması gerekir.</x-quiz.option>

                <x-slot:explanation>
                    Türk Ceza Kanunu bir bilişim sistemine izinsiz girmeyi suç sayar; iyi niyet bunu değiştirmez. Doğru yol, önce izin almak ya da bir hata
                    ödül programının kurallarıyla çalışmaktır.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Etik hack pratiği yapmak için hangisi yasal bir yoldur?">
                <x-quiz.option>Okulun internet sitesinde denemek.</x-quiz.option>
                <x-quiz.option>Bir arkadaşın hesabında, ona söylemeden denemek.</x-quiz.option>
                <x-quiz.option correct>Kendi kurduğum eğitim laboratuvarında ya da bir CTF yarışmasında denemek.</x-quiz.option>

                <x-slot:explanation>
                    Eğitim laboratuvarları ve CTF yarışmaları tam olarak denenmek için kurulur. Başkasına ait bir sistemde, sahibi izin vermeden yapılan her deneme izinsiz giriştir.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
