<?php

namespace App\Enums;

/**
 * The colors a learner can give their own Bit, the mascot shown on their profile.
 */
enum AvatarColor: string
{
    case Mint = 'mint';
    case Amber = 'amber';
    case Sky = 'sky';
    case Rose = 'rose';
    case Violet = 'violet';

    public function label(): string
    {
        return match ($this) {
            self::Mint => 'Nane',
            self::Amber => 'Kehribar',
            self::Sky => 'Gökyüzü',
            self::Rose => 'Gül',
            self::Violet => 'Menekşe',
        };
    }

    /**
     * Main body color of the mascot.
     */
    public function body(): string
    {
        return match ($this) {
            self::Mint => '#3fd17c',
            self::Amber => '#ffc23d',
            self::Sky => '#4cb8ff',
            self::Rose => '#ff7aa2',
            self::Violet => '#a98bff',
        };
    }

    /**
     * Darker tone for the mascot's feet, antenna and outlines.
     */
    public function shade(): string
    {
        return match ($this) {
            self::Mint => '#2a9d58',
            self::Amber => '#d99a12',
            self::Sky => '#2b8bd1',
            self::Rose => '#d9527b',
            self::Violet => '#7c62d9',
        };
    }
}
