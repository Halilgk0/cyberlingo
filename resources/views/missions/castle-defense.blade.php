@php
    /*
     * The five layers of the castle and what each one stands for in cyber security,
     * from the outside in.
     *
     * @var array<string, array{name: string, cyber: string, text: string, fallen: string}> $layers
     */
    $layers = [
        'moat' => [
            'name' => 'Hendek',
            'cyber' => 'Güvenlik duvarı ve güncellemeler',
            'text' => 'Hendek, düşmanın surlara yaklaşmasını zorlaştırırdı. Bilgisayarındaki güvenlik duvarı istenmeyen bağlantıları dışarıda tutar; güncellemeler de saldırganların bildiği açıkları kapatır.',
            'fallen' => 'Hendek kuruysa: güncellenmemiş bir sistemdeki bilinen bir açık, saldırganı doğrudan surların dibine getirir.',
        ],
        'walls' => [
            'name' => 'Surlar',
            'cyber' => 'Güçlü ve tekrar kullanılmayan parolalar',
            'text' => 'Kalın surlar kalenin çevresini sarar. Uzun, tahmin edilemeyen ve her hesapta farklı olan parolalar da hesaplarının etrafındaki surlardır.',
            'fallen' => 'Surlar alçaksa: “123456” gibi bir parola, sözlük saldırısında saniyeler içinde aşılır.',
        ],
        'gate' => [
            'name' => 'Kapı ve ikinci anahtar',
            'cyber' => 'İki adımlı doğrulama',
            'text' => 'Surları aşan biri bile kapının ikinci kilidini açamaz, çünkü o anahtar senin telefonunda. Parolan sızsa bile içeri giremezler.',
            'fallen' => 'Kapı tek kilitliyse: sızan tek bir parola bütün kaleyi açar.',
        ],
        'towers' => [
            'name' => 'Nöbetçi kuleleri',
            'cyber' => 'Dikkatin ve uyarılar',
            'text' => 'Nöbetçiler yaklaşan tehlikeyi görür ve alarm verir. Sahte bir e-postayı fark eden gözlerin, bankanın “yeni cihazdan giriş” bildirimi ve antivirüs uyarıları senin nöbetçilerindir.',
            'fallen' => 'Nöbetçiler uyuyorsa: oltalama e-postası kapıdan misafir kılığında girer.',
        ],
        'keep' => [
            'name' => 'Hazine odası',
            'cyber' => 'Şifreleme ve yedekler',
            'text' => 'En değerli şeyler kalenin en iç odasında, kilitli sandıklarda durur; bir kopyası da gizli bir mahzendedir. Şifreleme verini okunmaz kılar, yedek de her şey kaybolsa bile onu geri getirir.',
            'fallen' => 'Hazine korumasızsa: içeri sızan biri her şeyi okur ya da fidye yazılımıyla kilitler.',
        ],
    ];
@endphp

<x-layouts.mission :mission="$mission" :steps="['kale' => 'Keşfet', 'sina' => 'Sına']">
    <x-slot:intro>
        Orta Çağ kaleleri tek bir duvara güvenmezdi: hendek, surlar, kapı, nöbetçiler ve en içte hazine odası birbirini korurdu.
        Siber güvenlikte de aynı fikir var. Bu kısa ara bilgide kalenin katmanlarını gezeceğiz; her birinin bugünkü karşılığını göreceksin.
    </x-slot:intro>

    <x-mission.step id="kale" number="1" title="Kalenin beş katmanı">
        <div class="lesson">
            <p>
                Bir katmana tıkla ve siber dünyadaki karşılığını öğren. Beşini de gezdiğinde, neden tek bir duvarın asla yetmediğini anlayacaksın.
            </p>
        </div>

        <div data-castle data-requirement="Kalenin beş katmanını incele" class="mt-6 grid items-start gap-6 lg:grid-cols-[1fr_17rem]">
            <div class="bg-card border-line riveted relative overflow-hidden rounded-[1.5rem] border-2 p-4 sm:p-6">
                <span aria-hidden="true" class="torch pointer-events-none absolute -top-24 left-1/2 size-80 -translate-x-1/2 rounded-full bg-[radial-gradient(circle,rgb(255_138_61/0.16),transparent_65%)]"></span>

                <svg data-castle-art viewBox="0 0 360 230" aria-hidden="true" class="castle-art relative w-full">
                    <g data-castle-part="keep">
                        <rect x="145" y="38" width="70" height="90" fill="#3a3440" stroke="#1d1a21" stroke-width="2" />
                        @foreach ([145, 163, 181, 199] as $merlon)
                            <rect x="{{ $merlon }}" y="28" width="12" height="12" fill="#3a3440" stroke="#1d1a21" stroke-width="2" />
                        @endforeach
                        <rect x="171" y="62" width="18" height="22" rx="9" fill="#e8b04a" />
                        <path d="M175 79h10v-6h-10Z" fill="#8a6424" />
                        <path d="M180 28V6" stroke="#8a7a5a" stroke-width="2" />
                        <path d="M180 6h22l-5 5 5 5h-22Z" fill="#c2384a" />
                    </g>

                    <g data-castle-part="towers">
                        @foreach ([40, 274] as $tower)
                            <rect x="{{ $tower }}" y="78" width="46" height="118" fill="#433c4a" stroke="#1d1a21" stroke-width="2" />
                            @foreach ([0, 17, 34] as $step)
                                <rect x="{{ $tower + $step }}" y="68" width="12" height="12" fill="#433c4a" stroke="#1d1a21" stroke-width="2" />
                            @endforeach
                            <rect x="{{ $tower + 17 }}" y="100" width="12" height="18" rx="6" fill="#120f15" />
                            <circle cx="{{ $tower + 23 }}" cy="96" r="9" fill="#ff8a3d" opacity="0.25" class="torch" />
                            <circle cx="{{ $tower + 23 }}" cy="98" r="3" fill="#ffb15e" />
                        @endforeach
                    </g>

                    <g data-castle-part="walls">
                        <rect x="84" y="118" width="192" height="78" fill="#4b4453" stroke="#1d1a21" stroke-width="2" />
                        @for ($merlon = 84; $merlon < 276; $merlon += 24)
                            <rect x="{{ $merlon }}" y="106" width="14" height="14" fill="#4b4453" stroke="#1d1a21" stroke-width="2" />
                        @endfor
                        @foreach ([132, 150, 168, 186] as $row)
                            <path d="M86 {{ $row }}H274" stroke="#3a3440" stroke-width="1.5" />
                        @endforeach
                    </g>

                    <g data-castle-part="gate">
                        <path d="M158 196V160a22 22 0 0 1 44 0v36Z" fill="#120f15" stroke="#e8b04a" stroke-width="2" />
                        @foreach ([168, 180, 192] as $bar)
                            <path d="M{{ $bar }} 146V196" stroke="#8a7a5a" stroke-width="2" />
                        @endforeach
                        @foreach ([164, 178] as $bar)
                            <path d="M160 {{ $bar }}H200" stroke="#8a7a5a" stroke-width="2" />
                        @endforeach
                        <rect x="158" y="196" width="44" height="9" fill="#6b4a2b" stroke="#1d1a21" stroke-width="1.5" />
                    </g>

                    <g data-castle-part="moat">
                        <path d="M0 200q30-6 60 0t60 0 60 0 60 0 60 0 60 0V230H0Z" fill="#1d4466" />
                        <path d="M10 214q20-4 40 0t40 0M150 220q20-4 40 0t40 0M260 212q20-4 40 0t40 0" fill="none" stroke="#5ee6d0" stroke-width="1.5" opacity="0.45" />
                    </g>
                </svg>

                <div data-castle-info aria-live="polite" class="relative mt-4 min-h-28">
                    <p class="text-muted text-center">Başlamak için kaleden ya da listeden bir katman seç.</p>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <p class="text-muted text-sm font-bold">İncelediğin katmanlar: <span data-castle-progress class="text-ink">0</span> / {{ count($layers) }}</p>
                @foreach ($layers as $layer => $details)
                    <button
                        type="button"
                        data-castle-layer="{{ $layer }}"
                        aria-pressed="false"
                        class="group border-line bg-card aria-pressed:border-signal aria-pressed:bg-signal/10 focus-visible:outline-ink flex items-center gap-3 rounded-2xl border-2 px-3 py-2.5 text-left transition-colors hover:border-signal/60 focus-visible:outline-2"
                    >
                        <span class="bg-line group-data-[inspected]:bg-safe font-rune grid size-8 shrink-0 place-items-center rounded-full text-xs font-bold text-[#0c0b0f] transition-colors">{{ ['I', 'II', 'III', 'IV', 'V'][$loop->index] }}</span>
                        <span>
                            <span class="block font-bold">{{ $details['name'] }}</span>
                            <span class="text-muted block text-sm leading-snug">{{ $details['cyber'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>

            @foreach ($layers as $layer => $details)
                <template data-castle-template="{{ $layer }}">
                    <p class="rune-label text-rune">{{ $details['cyber'] }}</p>
                    <p class="font-display mt-1 text-3xl font-extrabold">{{ $details['name'] }}</p>
                    <p class="mt-2 leading-relaxed">{{ $details['text'] }}</p>
                    <p class="text-alert mt-3 text-sm font-bold leading-relaxed">{{ $details['fallen'] }}</p>
                </template>
            @endforeach
        </div>

        <div class="lesson mt-10">
            <h3>Neden tek duvar yetmez?</h3>
            <p>
                Her katmanın bir zayıf noktası vardır: parolalar sızar, insanlar yorulur ve dikkatsiz anlar yaşar, yazılımlarda açıklar bulunur.
                Ama saldırganın içeri girebilmesi için <strong>bütün katmanları aynı anda</strong> aşması gerekir. Bir katman düştüğünde
                arkasındaki onu yakalar. Uzmanlar buna <strong>derinlemesine savunma</strong> der.
            </p>
            <p>
                Bu yoldaki görevlerin her biri kalene yeni bir katman ekliyor. Parola görevi surlarını yükseltecek, iki adımlı doğrulama kapına
                ikinci kilidi takacak, oltalama görevleri nöbetçilerini uyandıracak, yedekleme görevi de hazinenin gizli kopyasını çıkaracak.
            </p>
        </div>

        <x-callout title="Delikli peynir dilimleri" class="mt-8">
            Güvenlik uzmanları bu fikri üst üste konmuş delikli peynir dilimlerine benzetir. Her dilimde delikler vardır, ama dilimler
            üst üste gelince deliklerin bir hizaya gelip baştan sona bir yol açması çok zordur. Ne kadar çok dilim, o kadar az şans.
        </x-callout>
    </x-mission.step>

    <x-mission.step id="sina" number="2" title="Kendini sına">
        <x-quiz>
            <x-quiz.question prompt="Saldırgan parolanı bir sızıntıdan öğrendi. Hangi katman onu hâlâ durdurabilir?">
                <x-quiz.option>Hendek: güvenlik duvarı</x-quiz.option>
                <x-quiz.option correct>Kapı: iki adımlı doğrulama</x-quiz.option>
                <x-quiz.option>Hiçbiri; parola bilinince her şey biter.</x-quiz.option>

                <x-slot:explanation>
                    Surlar (parola) aşıldı ama kapının ikinci kilidi telefonunda. Derinlemesine savunmanın gücü tam olarak bu.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Bir fidye yazılımı bütün savunmaları aşıp dosyalarını kilitledi. Hangi katman seni kurtarır?">
                <x-quiz.option>Nöbetçiler: antivirüs uyarısı</x-quiz.option>
                <x-quiz.option correct>Hazine odası: ayrı bir yerde tutulan yedekler</x-quiz.option>
                <x-quiz.option>Surlar: daha uzun bir parola</x-quiz.option>

                <x-slot:explanation>
                    Saldırı içeri girdikten sonra bile yedek, kaybolan her şeyi geri getirir. Son katman bu yüzden hayati önemde.
                </x-slot:explanation>
            </x-quiz.question>

            <x-quiz.question prompt="Derinlemesine savunmanın asıl fikri nedir?">
                <x-quiz.option>Tek bir çok güçlü önlem almak.</x-quiz.option>
                <x-quiz.option correct>Birbirini tamamlayan birkaç katman kullanmak, böylece biri düşünce diğerinin yakalaması.</x-quiz.option>
                <x-quiz.option>Saldırganı kaleye hiç yaklaştırmamak.</x-quiz.option>

                <x-slot:explanation>
                    Hiçbir önlem kusursuz değildir. Katmanlar, birinin zayıf anını diğerinin kapatmasını sağlar.
                </x-slot:explanation>
            </x-quiz.question>
        </x-quiz>
    </x-mission.step>
</x-layouts.mission>
