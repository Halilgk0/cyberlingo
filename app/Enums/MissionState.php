<?php

namespace App\Enums;

/**
 * Where a mission stands on a visitor's learning path.
 */
enum MissionState: string
{
    case Completed = 'completed';
    case Current = 'current';
    case Locked = 'locked';
}
