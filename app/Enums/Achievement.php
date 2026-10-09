<?php

namespace App\Enums;

use App\Models\User;

/**
 * Badges a learner earns along the way. They are worked out from the learner's
 * completions every time, so nothing extra is stored.
 */
enum Achievement: string
{
    case FirstStep = 'ilk-adim';
    case BasicsDone = 'temel-atildi';
    case AccountsDone = 'hesap-bekcisi';
    case TrapsDone = 'tuzak-avcisi';
    case PrivacyDone = 'mahremiyet-koruyucusu';
    case DataDone = 'veri-kalkani';
    case CrisisDone = 'sogukkanli';
    case EthicsDone = 'beyaz-sapka';
    case DefenseDone = 'gozcu';
    case DragonSlayer = 'ejderha-avcisi';
    case Practiced = 'pratik-yapan';
    case ThreeDayStreak = 'uc-gunluk-seri';
    case WeekStreak = 'yedi-gunluk-seri';
    case FiveHundredXp = 'bes-yuz-xp';
    case ChecklistDone = 'kale-denetcisi';
    case AllMissions = 'siber-kahraman';

    public function title(): string
    {
        return match ($this) {
            self::FirstStep => 'İlk adım',
            self::BasicsDone => 'Temel atıldı',
            self::AccountsDone => 'Hesap bekçisi',
            self::TrapsDone => 'Tuzak avcısı',
            self::PrivacyDone => 'Mahremiyet koruyucusu',
            self::DataDone => 'Veri kalkanı',
            self::CrisisDone => 'Soğukkanlı',
            self::EthicsDone => 'Beyaz şapka',
            self::DefenseDone => 'Gözcü',
            self::DragonSlayer => 'Ejderha avcısı',
            self::Practiced => 'Pratik yapan',
            self::ThreeDayStreak => 'Isınma turu',
            self::WeekStreak => 'Ateş gibi',
            self::FiveHundredXp => 'Beş yüzlük',
            self::ChecklistDone => 'Kale denetçisi',
            self::AllMissions => 'Siber kahraman',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::FirstStep => 'İlk görevini tamamla.',
            self::BasicsDone => '“Temeller” bölümünü bitir.',
            self::AccountsDone => '“Hesaplarını koru” bölümünü bitir.',
            self::TrapsDone => '“Tuzakları tanı” bölümünü bitir.',
            self::PrivacyDone => '“Mahremiyetini koru” bölümünü bitir.',
            self::DataDone => '“Verini ve bağlantını koru” bölümünü bitir.',
            self::CrisisDone => '“Kriz anında” bölümünü bitir.',
            self::EthicsDone => '“Etik hack” bölümünü bitir.',
            self::DefenseDone => '“Savunma hattı” bölümünü bitir.',
            self::DragonSlayer => 'Bir ejderha sınavını geç.',
            self::Practiced => 'Bitirdiğin bir görevi tekrar oyna.',
            self::ThreeDayStreak => '3 gün üst üste görev yap.',
            self::WeekStreak => '7 gün üst üste görev yap.',
            self::FiveHundredXp => 'Toplam 500 XP topla.',
            self::ChecklistDone => 'Kale kontrol listesindeki bütün maddeleri işaretle.',
            self::AllMissions => 'Öğrenme yolundaki bütün görevleri tamamla.',
        };
    }

    public function emoji(): string
    {
        return match ($this) {
            self::FirstStep => '👣',
            self::BasicsDone => '🧱',
            self::AccountsDone => '🔐',
            self::TrapsDone => '🎣',
            self::PrivacyDone => '🕶️',
            self::DataDone => '🛡️',
            self::CrisisDone => '🚨',
            self::EthicsDone => '🎩',
            self::DefenseDone => '🔭',
            self::DragonSlayer => '🐉',
            self::Practiced => '🔁',
            self::ThreeDayStreak => '🔥',
            self::WeekStreak => '☄️',
            self::FiveHundredXp => '⚡',
            self::ChecklistDone => '📜',
            self::AllMissions => '🏆',
        };
    }

    public function isEarnedBy(User $user): bool
    {
        $completedChapter = fn (Chapter $chapter): bool => array_diff(
            array_map(fn (Mission $mission) => $mission->value, $chapter->missions()),
            array_map(fn (Mission $mission) => $mission->value, $user->completedMissions()),
        ) === [];

        return match ($this) {
            self::FirstStep => $user->completedMissions() !== [],
            self::BasicsDone => $completedChapter(Chapter::Basics),
            self::AccountsDone => $completedChapter(Chapter::Accounts),
            self::TrapsDone => $completedChapter(Chapter::Traps),
            self::PrivacyDone => $completedChapter(Chapter::Privacy),
            self::DataDone => $completedChapter(Chapter::DataAndConnections),
            self::CrisisDone => $completedChapter(Chapter::Crisis),
            self::EthicsDone => $completedChapter(Chapter::EthicalHacking),
            self::DefenseDone => $completedChapter(Chapter::Defense),
            self::DragonSlayer => collect($user->completedMissions())->contains(fn (Mission $mission) => $mission->kind() === MissionKind::Challenge),
            self::Practiced => $user->replayCount() > 0,
            self::ThreeDayStreak => $user->longestStreak() >= 3,
            self::WeekStreak => $user->longestStreak() >= 7,
            self::FiveHundredXp => $user->totalXp() >= 500,
            self::ChecklistDone => count($user->checkedItems()) === count(ChecklistItem::cases()),
            self::AllMissions => count($user->completedMissions()) === count(Mission::cases()),
        };
    }
}
