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
        return (int) $this->missionCompletions->sum('xp');
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
     * Consecutive days with at least one completion, ending today. A streak that ended
     * yesterday still counts, so it does not reset before the learner had a chance to play today.
     */
    public function streak(): int
    {
        $activeDates = $this->activeDates();
        $day = CarbonImmutable::today();

        if (! $activeDates->contains($day->toDateString())) {
            $day = $day->subDay();
        }

        $streak = 0;

        while ($activeDates->contains($day->toDateString())) {
            $streak++;
            $day = $day->subDay();
        }

        return $streak;
    }

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
                'xp' => (int) $this->missionCompletions
                    ->filter(fn (MissionCompletion $completion) => $completion->created_at->isSameDay($day))
                    ->sum('xp'),
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
            $this->load('missionCompletions');
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
            ->unique()
            ->sort()
            ->values();
    }
}
