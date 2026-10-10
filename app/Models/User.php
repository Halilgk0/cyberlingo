<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Achievement;
use App\Enums\AvatarColor;
use App\Enums\ChecklistItem;
use App\Enums\Mission;
use App\Enums\Rank;
use Carbon\CarbonImmutable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * A learner. Everything about their progress (XP, streak, rank, badges) is worked
 * out from their mission completions, which are loaded once per request.
 */
#[Fillable(['name', 'email', 'password', 'avatar_color', 'checklist'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * XP that counts as a finished day for the daily goal ring.
     */
    public const DAILY_GOAL_XP = 50;

    /**
     * Single missed days the live streak forgives before it resets.
     */
    public const STREAK_FREEZES = 1;

    /**
     * XP for finishing a daily review session, given at most once a day.
     */
    public const REVIEW_XP = 20;

    /**
     * Mirrors the column default, so a freshly registered learner already has a mascot color.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'avatar_color' => 'mint',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'avatar_color' => AvatarColor::class,
            'checklist' => AsEnumCollection::of(ChecklistItem::class),
        ];
    }

    /**
     * @return HasMany<MissionCompletion, $this>
     */
    public function missionCompletions(): HasMany
    {
        return $this->hasMany(MissionCompletion::class);
    }

    /**
     * The learner's mistake notebook: quiz questions they got wrong, for later review.
     *
     * @return HasMany<ReviewItem, $this>
     */
    public function reviewItems(): HasMany
    {
        return $this->hasMany(ReviewItem::class);
    }

    /**
     * How many saved questions are due to be reviewed today.
     */
    public function dueReviewCount(): int
    {
        return $this->reviewItems()->due()->count();
    }

    /**
     * XP earned outside missions, such as review sessions.
     *
     * @return HasMany<XpAward, $this>
     */
    public function xpAwards(): HasMany
    {
        return $this->hasMany(XpAward::class);
    }

    /**
     * Whether the learner has already earned the review bonus today.
     */
    public function earnedReviewBonusToday(): bool
    {
        return $this->xpAwards
            ->contains(fn (XpAward $award) => $award->source === 'review' && $award->created_at->isToday());
    }

    /**
     * Missions completed at least once, in path order.
     *
     * @return list<Mission>
     */
    public function completedMissions(): array
    {
        return array_values(array_filter(Mission::cases(), fn (Mission $mission) => $this->hasCompleted($mission)));
    }

    public function hasCompleted(Mission $mission): bool
    {
        return $this->missionCompletions->contains(fn (MissionCompletion $completion) => $completion->mission === $mission);
    }

    /**
     * Missions open up one by one: each needs the one before it.
     */
    public function canStart(Mission $mission): bool
    {
        $previous = $mission->previous();

        return $previous === null || $this->hasCompleted($previous);
    }

    /**
     * The first mission on the path the learner has not completed yet, or null once all are done.
     */
    public function currentMission(): ?Mission
    {
        return collect(Mission::cases())->first(fn (Mission $mission) => ! $this->hasCompleted($mission));
    }

    public function totalXp(): int
    {
        return (int) ($this->missionCompletions->sum('xp') + $this->xpAwards->sum('xp'));
    }

    public function rank(): Rank
    {
        return Rank::forXp($this->totalXp());
    }

    /**
     * How many times the learner played a mission they had already completed.
     */
    public function replayCount(): int
    {
        return $this->missionCompletions->count() - count($this->completedMissions());
    }

    /**
     * How many days in a row the learner has practised, counting back from today. Today may
     * still be empty (they have until midnight), and one single missed day inside the run is
     * forgiven — a built-in "streak freeze" — so a single slip does not reset the streak to zero.
     * Two missed days in a row do end it.
     */
    public function streak(): int
    {
        $activeDates = $this->activeDates();

        if ($activeDates->isEmpty()) {
            return 0;
        }

        $earliest = CarbonImmutable::parse($activeDates->first());
        $active = array_flip($activeDates->all());

        $day = CarbonImmutable::today();
        $streak = 0;
        $graceUsed = false;
        $freezes = self::STREAK_FREEZES;

        while ($day->greaterThanOrEqualTo($earliest)) {
            if (isset($active[$day->toDateString()])) {
                $streak++;
            } elseif (! $graceUsed && $day->isToday()) {
                $graceUsed = true;
            } elseif ($freezes > 0) {
                $freezes--;
            } else {
                break;
            }

            $day = $day->subDay();
        }

        return $streak;
    }

    /**
     * The streak is alive but today has not been practised yet, so it needs attention.
     */
    public function streakInDanger(): bool
    {
        return $this->streak() >= 1 && ! $this->hasPracticedToday();
    }

    public function xpEarnedToday(): int
    {
        $onToday = fn ($record) => $record->created_at->isToday();

        return (int) (
            $this->missionCompletions->filter($onToday)->sum('xp')
            + $this->xpAwards->filter($onToday)->sum('xp')
        );
    }

    public function reachedDailyGoal(): bool
    {
        return $this->xpEarnedToday() >= self::DAILY_GOAL_XP;
    }

    /**
     * The longest run of strictly consecutive active days, ever. This stays strict (no freeze),
     * so the streak badges reward genuinely unbroken runs.
     */
    public function longestStreak(): int
    {
        $longest = 0;
        $current = 0;
        $previousDay = null;

        foreach ($this->activeDates() as $date) {
            $day = CarbonImmutable::parse($date);
            $current = $previousDay?->addDay()->isSameDay($day) ? $current + 1 : 1;
            $longest = max($longest, $current);
            $previousDay = $day;
        }

        return $longest;
    }

    public function hasPracticedToday(): bool
    {
        return $this->activeDates()->contains(CarbonImmutable::today()->toDateString());
    }

    /**
     * XP earned on each of the last `$days` days, oldest first.
     *
     * @return list<array{date: CarbonImmutable, xp: int}>
     */
    public function dailyXp(int $days = 7): array
    {
        return array_map(function (int $daysAgo): array {
            $day = CarbonImmutable::today()->subDays($daysAgo);

            return [
                'date' => $day,
                'xp' => (int) (
                    $this->missionCompletions->filter(fn ($record) => $record->created_at->isSameDay($day))->sum('xp')
                    + $this->xpAwards->filter(fn ($record) => $record->created_at->isSameDay($day))->sum('xp')
                ),
            ];
        }, range($days - 1, 0));
    }

    /**
     * The items the learner has ticked on their security checklist, in list order.
     *
     * @return list<ChecklistItem>
     */
    public function checkedItems(): array
    {
        return array_values(array_filter(
            ChecklistItem::cases(),
            fn (ChecklistItem $item) => $this->checklist?->contains($item) ?? false,
        ));
    }

    /**
     * @return list<Achievement>
     */
    public function earnedAchievements(): array
    {
        return array_values(array_filter(Achievement::cases(), fn (Achievement $achievement) => $achievement->isEarnedBy($this)));
    }

    /**
     * Records a completion and returns the XP it earned: the mission's full XP the first time,
     * then a small replay bonus at most once a day. A replay without XP is not recorded.
     */
    public function completeMission(Mission $mission): int
    {
        $playedToday = $this->missionCompletions->contains(
            fn (MissionCompletion $completion) => $completion->mission === $mission && $completion->created_at->isToday(),
        );

        $xp = match (true) {
            ! $this->hasCompleted($mission) => $mission->xp(),
            $playedToday => 0,
            default => Mission::REPLAY_XP,
        };

        if ($xp > 0) {
            $this->missionCompletions()->create(['mission' => $mission, 'xp' => $xp]);
            $this->load(['missionCompletions', 'xpAwards']);
        }

        return $xp;
    }

    /**
     * Moves missions finished as a guest to this account.
     *
     * @param  list<Mission>  $missions
     */
    public function claimGuestProgress(array $missions): void
    {
        foreach ($missions as $mission) {
            if (! $this->hasCompleted($mission)) {
                $this->completeMission($mission);
            }
        }
    }

    /**
     * Distinct days with at least one completion, as Y-m-d strings in ascending order.
     *
     * @return Collection<int, string>
     */
    private function activeDates(): Collection
    {
        return $this->missionCompletions
            ->map(fn (MissionCompletion $completion) => $completion->created_at->toDateString())
            ->merge($this->xpAwards->map(fn (XpAward $award) => $award->created_at->toDateString()))
            ->unique()
            ->sort()
            ->values();
    }
}
