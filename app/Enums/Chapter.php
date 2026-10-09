<?php

namespace App\Enums;

/**
 * The chapters that group missions on the learning path, in path order.
 */
enum Chapter: string
{
    case Basics = 'temeller';
    case Accounts = 'hesaplar';
    case Traps = 'tuzaklar';
    case Privacy = 'mahremiyet';
    case DataAndConnections = 'veri-ve-baglanti';
    case Crisis = 'kriz-aninda';

    /**
     * Position of the chapter on the learning path, starting at 1.
     */
    public function number(): int
    {
        return array_search($this, self::cases(), true) + 1;
    }

    /**
     * The chapter number in Roman numerals, as carved on its banner.
     */
    public function numeral(): string
    {
        return ['I', 'II', 'III', 'IV', 'V', 'VI'][$this->number() - 1];
    }

    public function title(): string
    {
        return match ($this) {
            self::Basics => 'Temeller',
            self::Accounts => 'Hesaplarını koru',
            self::Traps => 'Tuzakları tanı',
            self::Privacy => 'Mahremiyetini koru',
            self::DataAndConnections => 'Verini ve bağlantını koru',
            self::Crisis => 'Kriz anında',
        };
    }

    public function summary(): string
    {
        return match ($this) {
            self::Basics => 'Siber güvenliğin ne olduğunu ve neyi koruduğunu öğren.',
            self::Accounts => 'Parolalar ve iki adımlı doğrulamayla hesaplarına kimsenin girmesine izin verme.',
            self::Traps => 'Sahte bağlantıları, e-postaları, mesajları ve mağazaları ilk bakışta fark et.',
            self::Privacy => 'Paylaştıklarını ve uygulamaların neye eriştiğini kontrol altında tut.',
            self::DataAndConnections => 'Şifrelemeyi, halka açık ağları, zararlı yazılımları ve yedeklemeyi öğren.',
            self::Crisis => 'Bir şeyler ters gittiğinde paniğe kapılmadan, doğru sırayla hareket et.',
        };
    }

    /**
     * The color of the chapter's banner and shields on the learning path.
     */
    public function accent(): string
    {
        return match ($this) {
            self::Basics => '#3ddc84',
            self::Accounts => '#5aa9ff',
            self::Traps => '#e8b04a',
            self::Privacy => '#ff6f91',
            self::DataAndConnections => '#a98bff',
            self::Crisis => '#ff8a3d',
        };
    }

    /**
     * Blade component name of the coat of arms on the chapter's banner.
     */
    public function emblem(): string
    {
        return match ($this) {
            self::Basics => 'icons.castle',
            self::Accounts => 'icons.key',
            self::Traps => 'icons.hook',
            self::Privacy => 'icons.eye',
            self::DataAndConnections => 'icons.cipher',
            self::Crisis => 'icons.siren',
        };
    }

    /**
     * A short “did you know?” shown on the path under the chapter's banner.
     */
    public function lore(): string
    {
        return match ($this) {
            self::Basics => 'Orta Çağ kaleleri tek bir duvara güvenmezdi: hendek, surlar, kapı ve nöbetçiler birbirini korurdu. Siber güvenlik de aynı fikirle çalışır; buna derinlemesine savunma denir.',
            self::Accounts => 'Orta Çağ’da mektuplar mühürle kapatılırdı: mühür kırıksa mektup açılmış demekti. İki adımlı doğrulama da hesabına vurulmuş ikinci bir mühür gibidir.',
            self::Traps => '“Phishing” kelimesi 1990’larda “fishing” (balık tutmak) sözcüğünden türetildi. Baştaki “ph”, o yılların telefon korsanlarına (phreaker) bir göndermeydi.',
            self::Privacy => 'Eski çağların casusları pazar yerlerinde dedikodu dinleyerek bilgi toplardı. Bugün aynı işi herkese açık profiller ve uygulama izinleri çok daha kolay yapıyor.',
            self::DataAndConnections => '1988’de yayılan Morris solucanı, o zamanlar internete bağlı bilgisayarların yaklaşık onda birini yavaşlattı ya da çökertti. İlk büyük internet saldırılarından biri kabul edilir.',
            self::Crisis => 'Bizans İmparatorluğu’nun 9. yüzyıldaki işaret ateşleri, Toros Dağları’ndaki sınırda görülen bir akını yaklaşık 700 kilometre ötedeki İstanbul’a bir saat kadar içinde haber verirdi. Krizde hız da sıra da hayat kurtarır.',
        };
    }

    /**
     * The missions of this chapter, in path order.
     *
     * @return list<Mission>
     */
    public function missions(): array
    {
        return array_values(array_filter(
            Mission::cases(),
            fn (Mission $mission) => $mission->chapter() === $this,
        ));
    }
}
