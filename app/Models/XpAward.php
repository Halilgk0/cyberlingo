<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * XP earned outside of a mission completion, for example a daily review session. Kept
 * separate from mission completions so mission stats stay clean, but counted in the totals.
 */
#[Fillable(['xp', 'source'])]
class XpAward extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
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
