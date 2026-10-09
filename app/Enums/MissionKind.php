<?php

namespace App\Enums;

/**
 * The kinds of missions on the path: full lessons, short interludes between them,
 * and the dragon trial that closes a chapter and has to be passed with a high score.
 */
enum MissionKind: string
{
    case Lesson = 'lesson';
    case Interlude = 'interlude';
    case Challenge = 'challenge';

    public function label(): string
    {
        return match ($this) {
            self::Lesson => 'Ders',
            self::Interlude => 'Ara bilgi',
            self::Challenge => 'Ejderha sınavı',
        };
    }

    /**
     * Extra XP on top of the mission's length-based reward, the first time it is completed.
     */
    public function bonusXp(): int
    {
        return match ($this) {
            self::Challenge => 50,
            self::Lesson, self::Interlude => 0,
        };
    }
}
