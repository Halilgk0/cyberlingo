<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One quiz question a learner answered wrong, stored so it can be reviewed again later.
 * `data` is a self-contained snapshot of the question, so a review never needs the lesson.
 *
 * @property array{prompt: string, code: ?string, options: list<array{text: string, correct: bool}>, explanation: ?string, mission: string, missionTitle: string} $data
 */
#[Fillable(['key', 'data', 'due_on'])]
class ReviewItem extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'due_on' => 'immutable_date',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Items whose review day has arrived.
     *
     * @param  Builder<ReviewItem>  $query
     */
    public function scopeDue(Builder $query): void
    {
        $query->whereDate('due_on', '<=', CarbonImmutable::today());
    }
}
