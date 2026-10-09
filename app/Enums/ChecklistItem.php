<?php

namespace App\Enums;

/**
 * The habits on a learner's personal security checklist, in the order they are listed.
 * Each one points to the mission that teaches it.
 */
enum ChecklistItem: string
{
    case EmailTwoFactor = 'e-posta-iki-adim';
    case UniquePasswords = 'farkli-parolalar';
    case PasswordManager = 'parola-kasasi';
    case RecoveryOptions = 'kurtarma-bilgileri';
    case BreachCheck = 'sizinti-kontrolu';
    case AutoUpdates = 'otomatik-guncelleme';
    case ScreenLock = 'ekran-kilidi';
    case FindMyDevice = 'cihazimi-bul';
    case OffsiteBackup = 'disarida-yedek';
    case PrivateProfiles = 'gizli-profil';
    case PermissionReview = 'izin-kontrolu';
    case OfficialNumbers = 'resmi-numaralar';

    /**
     * The heading the item is listed under.
     */
    public function group(): string
    {
        return match ($this) {
            self::EmailTwoFactor, self::UniquePasswords, self::PasswordManager, self::RecoveryOptions, self::BreachCheck => 'Hesapların',
            self::AutoUpdates, self::ScreenLock, self::FindMyDevice, self::OffsiteBackup => 'Cihazların ve dosyaların',
            self::PrivateProfiles, self::PermissionReview, self::OfficialNumbers => 'Mahremiyetin ve dolandırıcılara karşı',
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::EmailTwoFactor => 'E-posta hesabımda iki adımlı doğrulama açık.',
            self::UniquePasswords => 'Önemli hesaplarımın her birinde farklı bir parola var.',
            self::PasswordManager => 'Parolalarımı bir parola kasasında saklıyorum.',
            self::RecoveryOptions => 'Hesaplarımdaki kurtarma e-postası ve telefon numarası güncel.',
            self::BreachCheck => 'E-posta adresimin bir veri sızıntısında geçip geçmediğine baktım.',
            self::AutoUpdates => 'Telefonumda ve bilgisayarımda otomatik güncellemeler açık.',
            self::ScreenLock => 'Telefonumda en az 6 haneli bir ekran kilidi var.',
            self::FindMyDevice => 'Telefonumda “Cihazımı bul” özelliği açık.',
            self::OffsiteBackup => 'Önemli dosyalarımın evin dışında da bir kopyası var.',
            self::PrivateProfiles => 'Sosyal medya hesaplarımı yalnızca tanıdıklarım görebiliyor.',
            self::PermissionReview => 'Uygulamaların izinlerini son bir ay içinde gözden geçirdim.',
            self::OfficialNumbers => 'Bankamın resmi müşteri hizmetleri numarası rehberimde kayıtlı.',
        };
    }

    /**
     * One sentence on why the habit matters.
     */
    public function reason(): string
    {
        return match ($this) {
            self::EmailTwoFactor => 'E-postan, diğer bütün hesaplarının parola sıfırlama anahtarıdır.',
            self::UniquePasswords => 'Bir site sızdırıldığında yalnızca o hesap tehlikeye girer, hepsi değil.',
            self::PasswordManager => 'Kasa yüzlerce parolayı hatırlar ve sahte siteleri senden önce fark eder.',
            self::RecoveryOptions => 'Hesabın ele geçirilirse geri almanın tek yolu bunlar olabilir.',
            self::BreachCheck => 'Sızan parolaları değiştirmek, saldırganın elindeki listeyi işe yaramaz kılar.',
            self::AutoUpdates => 'Güncellemeler, saldırganların bildiği açıkları kapatır.',
            self::ScreenLock => 'Kaybolan bir telefondaki her şey, kilit ekranının arkasında bekler.',
            self::FindMyDevice => 'Kaybolan telefonu haritada görür, kilitler ya da uzaktan silersin.',
            self::OffsiteBackup => 'Yangın, hırsızlık ya da fidye yazılımı tek bir kopyayı yok edebilir.',
            self::PrivateProfiles => 'Herkese açık bir profil, dolandırıcıya hazır bir dosyadır.',
            self::PermissionReview => 'Kullanmadığın izinler, bir gün kötüye kullanılabilecek kapılardır.',
            self::OfficialNumbers => 'Şüpheli bir aramayı kapatıp bankanı kendin arayabilmen için.',
        };
    }

    /**
     * The mission that teaches how to do it.
     */
    public function mission(): Mission
    {
        return match ($this) {
            self::EmailTwoFactor => Mission::TwoFactor,
            self::UniquePasswords => Mission::StrongPassword,
            self::PasswordManager => Mission::PasswordVault,
            self::RecoveryOptions => Mission::AccountRecovery,
            self::BreachCheck => Mission::DataBreach,
            self::AutoUpdates => Mission::Malware,
            self::ScreenLock, self::FindMyDevice => Mission::LostPhone,
            self::OffsiteBackup => Mission::Backups,
            self::PrivateProfiles => Mission::Oversharing,
            self::PermissionReview => Mission::AppPermissions,
            self::OfficialNumbers => Mission::ScamMessages,
        };
    }
}
