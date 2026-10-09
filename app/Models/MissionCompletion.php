<?php

namespace App\Models;

use App\Enums\Mission;
use Database\Factories\MissionCompletionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One time a learner finished a mission. Replays are stored too, so they count
 * towards the learner's XP and daily streak.
 */
#[Fillable(['mission', 'xp'])]
class MissionCompletion extends Model
{
    /** @use HasFactory<MissionCompletionFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mission' => Mission::class,
            'xp' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
