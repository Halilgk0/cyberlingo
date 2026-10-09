<?php

namespace App\Enums;

/**
 * The missions a learner can play, in the order they are meant to be played.
 *
 * The backing value is the URL slug, so `/gorevler/guclu-parola` resolves
 * straight to `Mission::StrongPassword` through implicit enum binding.
 */
enum Mission: string
{
    case SecurityBasics = 'siber-guvenlige-ilk-adim';
    case CastleDefense = 'kale-savunmasi';
    case StrongPassword = 'guclu-parola';
    case TwoFactor = 'iki-adimli-dogrulama';
    case PasswordVault = 'parola-kasasi';
    case ReadingLinks = 'baglantinin-sahibi';
    case PhishingEmail = 'oltalama-e-postasi';
    case ScamMessages = 'dolandirici-mesajlari';
    case FakeShop = 'sahte-magaza';
    case PhishingDragon = 'ejderha-sinavi-oltalama';
    case Oversharing = 'paylasmadan-once-dusun';
    case AppPermissions = 'uygulama-izinleri';
    case Encryption = 'sifreleme';
    case PublicWifi = 'halka-acik-wifi';
    case Malware = 'truva-ati';
    case Backups = 'yedekle';
    case FinalSiege = 'son-sinav-kale-kusatmasi';

    /**
     * XP for replaying a mission already completed, given at most once a day per mission.
     */
    public const REPLAY_XP = 10;

    /**
     * Position of the mission on the learning path, starting at 1.
     */
    public function number(): int
    {
        return array_search($this, self::cases(), true) + 1;
    }

    /**
     * The mission that follows this one on the learning path, or null for the last one.
     */
    public function next(): ?self
    {
        return self::cases()[$this->number()] ?? null;
    }

    /**
     * The mission that has to be completed before this one, or null for the first one.
     */
    public function previous(): ?self
    {
        return self::cases()[$this->number() - 2] ?? null;
    }

    /**
     * XP for completing the mission the first time: longer missions are worth more,
     * and a dragon trial adds a bonus on top.
     */
    public function xp(): int
    {
        return $this->estimatedMinutes() * 10 + $this->kind()->bonusXp();
    }

    public function kind(): MissionKind
    {
        return match ($this) {
            self::CastleDefense, self::PasswordVault => MissionKind::Interlude,
            self::PhishingDragon, self::FinalSiege => MissionKind::Challenge,
            default => MissionKind::Lesson,
        };
    }

    public function chapter(): Chapter
    {
        return match ($this) {
            self::SecurityBasics, self::CastleDefense => Chapter::Basics,
            self::StrongPassword, self::TwoFactor, self::PasswordVault => Chapter::Accounts,
            self::ReadingLinks, self::PhishingEmail, self::ScamMessages, self::FakeShop, self::PhishingDragon => Chapter::Traps,
            self::Oversharing, self::AppPermissions => Chapter::Privacy,
            self::Encryption, self::PublicWifi, self::Malware, self::Backups, self::FinalSiege => Chapter::DataAndConnections,
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::SecurityBasics => 'Siber güvenliğe ilk adım',
            self::CastleDefense => 'Kaleni katman katman savun',
            self::StrongPassword => 'Güçlü bir parola oluştur',
            self::TwoFactor => 'İki adımlı doğrulamayı kur',
            self::PasswordVault => 'Parola kasanı kur',
            self::ReadingLinks => 'Bir bağlantının sahibini bul',
            self::PhishingEmail => 'Oltalama e-postasını yakala',
            self::ScamMessages => 'Dolandırıcı mesajlarını tanı',
            self::FakeShop => 'Sahte mağazayı tanı',
            self::PhishingDragon => 'Ejderha sınavı: Usta oltacı',
            self::Oversharing => 'Paylaşmadan önce düşün',
            self::AppPermissions => 'Uygulama izinlerini yönet',
            self::Encryption => 'Şifrelemenin sırrını çöz',
            self::PublicWifi => 'Halka açık Wi-Fi’da güvende kal',
            self::Malware => 'Truva atı ve zararlı yazılımlar',
            self::Backups => 'Fidye yazılımına karşı yedekle',
            self::FinalSiege => 'Son sınav: Kale kuşatması',
        };
    }

    public function summary(): string
    {
        return match ($this) {
            self::SecurityBasics => 'Siber güvenliğin neyi koruduğunu ve saldırganların senden ne istediğini öğren, sonra gerçek olayları doğru kutuya yerleştir.',
            self::CastleDefense => 'Bir Orta Çağ kalesinin katmanlarını gez ve her birinin siber dünyadaki karşılığını keşfet.',
            self::StrongPassword => 'Saldırganların parolaları nasıl tahmin ettiğini öğren, sonra kırılması yüzyıllar sürecek bir parola kur.',
            self::TwoFactor => 'Parolan çalınsa bile hesabını koruyan ikinci kilidi tanı, bir doğrulama uygulamasını adım adım kur ve saldırganın nerede takıldığını gör.',
            self::PasswordVault => 'Yüzlerce parolayı tek bir anahtarla saklayan kasayı dene ve kasanın sahte siteleri senden önce nasıl yakaladığını gör.',
            self::ReadingLinks => 'Bir internet adresinin parçalarını tanı ve bir bağlantının gerçekte kime ait olduğunu saniyeler içinde anla.',
            self::PhishingEmail => 'Sahte e-postaları ele veren ipuçlarını öğren ve gelen kutusundaki beş e-postadan hangilerinin tuzak olduğunu bul.',
            self::ScamMessages => 'Dolandırıcıların insanları nasıl kandırdığını öğren, sonra iki sahte mesajlaşmada doğru yanıtları seç.',
            self::FakeShop => 'İnanılmaz indirimlerin arkasındaki tuzakları öğren, sahte bir mağazada yedi tehlike işaretini bul ve güvenli alışverişi seç.',
            self::PhishingDragon => 'Bölümün son kapısı: en ustaca hazırlanmış beş e-posta. Geçmek için en az dördünü doğru bilmelisin.',
            self::Oversharing => 'Paylaşımlarının saldırganlara neler anlattığını öğren, sonra bir sosyal medya profilinde gizlenmiş yedi tehlikeli bilgiyi bul.',
            self::AppPermissions => 'Uygulamaların neden izin istediğini öğren ve dört uygulamaya yalnızca gerçekten ihtiyaç duydukları izinleri ver.',
            self::Encryption => 'Şifrelemenin nasıl çalıştığını Sezar çarkıyla dene, gizli bir mesajı kır ve modern şifrelerin neden kırılamadığını gör.',
            self::PublicWifi => 'Kafe ağındaki bir saldırganın neler görebildiğini kendi gözünle izle ve sahte ağların arasından doğru olanı seç.',
            self::Malware => 'Virüsten solucana, casus yazılımdan Truva atına zararlı yazılım türlerini tanı ve belirtilerden teşhis koy.',
            self::Backups => 'Bir fidye yazılımı saldırısını güvenle yaşa, sonra her felakete dayanan bir yedekleme planı kur.',
            self::FinalSiege => 'Bütün yolun son sınavı: on soruluk bir kuşatma, her soruya tek hak. Kaleyi savunmak için en az sekizini doğru bil.',
        };
    }

    public function estimatedMinutes(): int
    {
        return match ($this) {
            self::CastleDefense, self::PasswordVault => 4,
            self::SecurityBasics, self::StrongPassword => 5,
            self::ReadingLinks, self::ScamMessages => 6,
            self::PhishingEmail, self::FakeShop, self::Oversharing, self::AppPermissions, self::PublicWifi, self::Malware => 7,
            self::TwoFactor, self::PhishingDragon, self::Encryption, self::Backups => 8,
            self::FinalSiege => 10,
        };
    }

    /**
     * Blade component name of the mission's icon.
     */
    public function icon(): string
    {
        return match ($this) {
            self::SecurityBasics => 'icons.flag',
            self::CastleDefense => 'icons.castle',
            self::StrongPassword => 'icons.key',
            self::TwoFactor => 'icons.passcode',
            self::PasswordVault => 'icons.vault',
            self::ReadingLinks => 'icons.link',
            self::PhishingEmail => 'icons.hook',
            self::ScamMessages => 'icons.chat',
            self::FakeShop => 'icons.cart',
            self::PhishingDragon => 'icons.swords',
            self::Oversharing => 'icons.eye',
            self::AppPermissions => 'icons.smartphone',
            self::Encryption => 'icons.cipher',
            self::PublicWifi => 'icons.wifi',
            self::Malware => 'icons.bug',
            self::Backups => 'icons.archive',
            self::FinalSiege => 'icons.shield',
        };
    }

    public function view(): string
    {
        return match ($this) {
            self::SecurityBasics => 'missions.security-basics',
            self::CastleDefense => 'missions.castle-defense',
            self::StrongPassword => 'missions.strong-password',
            self::TwoFactor => 'missions.two-factor',
            self::PasswordVault => 'missions.password-vault',
            self::ReadingLinks => 'missions.reading-links',
            self::PhishingEmail => 'missions.phishing-email',
            self::ScamMessages => 'missions.scam-messages',
            self::FakeShop => 'missions.fake-shop',
            self::PhishingDragon => 'missions.phishing-dragon',
            self::Oversharing => 'missions.oversharing',
            self::AppPermissions => 'missions.app-permissions',
            self::Encryption => 'missions.encryption',
            self::PublicWifi => 'missions.public-wifi',
            self::Malware => 'missions.malware',
            self::Backups => 'missions.backups',
            self::FinalSiege => 'missions.final-siege',
        };
    }
}
