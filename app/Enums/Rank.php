<?php

namespace App\Enums;

/**
 * The learner's level. The backing value is the total XP needed to reach it.
 */
enum Rank: int
{
    case Apprentice = 0;
    case Squire = 100;
    case Guard = 250;
    case Knight = 450;
    case Castellan = 700;
    case Hero = 1000;

    public static function forXp(int $xp): self
    {
        return collect(self::cases())->last(fn (self $rank) => $xp >= $rank->value);
    }

    /**
     * Position of the rank, starting at 1, shown as the learner's level.
     */
    public function level(): int
    {
        return array_search($this, self::cases(), true) + 1;
    }

    public function title(): string
    {
        return match ($this) {
            self::Apprentice => 'Çırak',
            self::Squire => 'Yaver',
            self::Guard => 'Muhafız',
            self::Knight => 'Şövalye',
            self::Castellan => 'Kale Komutanı',
            self::Hero => 'Siber Kahraman',
        };
    }

    public function next(): ?self
    {
        return self::cases()[$this->level()] ?? null;
    }

    /**
     * How far `$xp` has come from this rank towards the next one, from 0 to 100.
     */
    public function progressFor(int $xp): int
    {
        $next = $this->next();

        if ($next === null) {
            return 100;
        }

        return (int) floor(($xp - $this->value) / ($next->value - $this->value) * 100);
    }
}
