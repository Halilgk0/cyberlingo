<?php

use App\Enums\Achievement;
use App\Enums\Chapter;
use App\Enums\ChecklistItem;
use App\Enums\Mission;
use App\Models\MissionCompletion;
use App\Models\User;

/**
 * Creates a learner who played a mission on each of the given days.
 */
function learnerActiveOn(string ...$days): User
{
    $learner = User::factory()->create();

    foreach ($days as $day) {
        MissionCompletion::factory()->for($learner)->of(Mission::SecurityBasics)->create(['created_at' => "{$day} 18:00"]);
    }

    return $learner->load('missionCompletions');
}

describe('streak', function () {
    beforeEach(function () {
        $this->travelTo('2026-10-09 09:00');
    });

    it('counts consecutive active days ending today', function () {
        expect(learnerActiveOn('2026-10-07', '2026-10-08', '2026-10-09')->streak())->toBe(3);
    });

    it('keeps a streak that ended yesterday, so it survives until the learner plays today', function () {
        expect(learnerActiveOn('2026-10-07', '2026-10-08')->streak())->toBe(2);
    });

    it('forgives a single missed day with the streak freeze', function () {
        // Today (09) is still open and yesterday (08) was missed, but one gap is forgiven.
        expect(learnerActiveOn('2026-10-05', '2026-10-06', '2026-10-07')->streak())->toBe(3);
    });

    it('resets to zero after two missed days in a row', function () {
        // Days 07, 08 and 09 are all empty: two real gaps, more than the freeze covers.
        expect(learnerActiveOn('2026-10-04', '2026-10-05', '2026-10-06')->streak())->toBe(0);
    });

    it('flags a live streak that has not been practised today as in danger', function () {
        expect(learnerActiveOn('2026-10-07', '2026-10-08')->streakInDanger())->toBeTrue()
            ->and(learnerActiveOn('2026-10-08', '2026-10-09')->streakInDanger())->toBeFalse();
    });

    it('counts several completions on the same day once', function () {
        expect(learnerActiveOn('2026-10-09', '2026-10-09')->streak())->toBe(1);
    });

    it('remembers the longest streak even after it ended', function () {
        expect(learnerActiveOn('2026-09-01', '2026-09-02', '2026-09-03', '2026-09-04', '2026-10-09')->longestStreak())->toBe(4);
    });
});

describe('path', function () {
    it('opens a mission only after the one before it is completed', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics)->create();

        expect($learner->canStart(Mission::SecurityBasics))->toBeTrue()
            ->and($learner->canStart(Mission::CastleDefense))->toBeTrue()
            ->and($learner->canStart(Mission::StrongPassword))->toBeFalse();
    });

    it('points at the first mission not completed yet', function () {
        expect(User::factory()->completed(Mission::SecurityBasics)->create()->currentMission())->toBe(Mission::CastleDefense)
            ->and(User::factory()->completed(...Mission::cases())->create()->currentMission())->toBeNull();
    });
});

describe('achievements', function () {
    it('awards the crisis badge once every mission of the crisis chapter is completed', function () {
        $almostDone = User::factory()->completed(...array_slice(Chapter::Crisis->missions(), 0, -1))->create();
        $done = User::factory()->completed(...Chapter::Crisis->missions())->create();

        expect($almostDone->earnedAchievements())->not->toContain(Achievement::CrisisDone)
            ->and($done->earnedAchievements())->toContain(Achievement::CrisisDone);
    });

    it('awards the ethical hacking badge once every mission of its chapter is completed', function () {
        $almostDone = User::factory()->completed(...array_slice(Chapter::EthicalHacking->missions(), 0, -1))->create();
        $done = User::factory()->completed(...Chapter::EthicalHacking->missions())->create();

        expect($almostDone->earnedAchievements())->not->toContain(Achievement::EthicsDone)
            ->and($done->earnedAchievements())->toContain(Achievement::EthicsDone);
    });

    it('awards the defense badge once every mission of its chapter is completed', function () {
        $almostDone = User::factory()->completed(...array_slice(Chapter::Defense->missions(), 0, -1))->create();
        $done = User::factory()->completed(...Chapter::Defense->missions())->create();

        expect($almostDone->earnedAchievements())->not->toContain(Achievement::DefenseDone)
            ->and($done->earnedAchievements())->toContain(Achievement::DefenseDone);
    });

    it('awards the checklist badge only once every item is ticked', function () {
        $almostDone = User::factory()->create(['checklist' => array_slice(ChecklistItem::cases(), 0, -1)]);
        $done = User::factory()->create(['checklist' => ChecklistItem::cases()]);

        expect($almostDone->earnedAchievements())->not->toContain(Achievement::ChecklistDone)
            ->and($done->earnedAchievements())->toContain(Achievement::ChecklistDone);
    });
});

describe('xp awards', function () {
    beforeEach(function () {
        $this->travelTo('2026-10-10 09:00');
    });

    it('counts review XP in the total, today and the streak', function () {
        $learner = User::factory()->create();
        MissionCompletion::factory()->for($learner)->create(['xp' => 50, 'created_at' => '2026-10-10 08:00']);
        $learner->xpAwards()->create(['xp' => 20, 'source' => 'review']);
        $learner->load(['missionCompletions', 'xpAwards']);

        expect($learner->totalXp())->toBe(70)
            ->and($learner->xpEarnedToday())->toBe(70)
            ->and($learner->hasPracticedToday())->toBeTrue();
    });

    it('lets a review-only day keep the streak alive', function () {
        $learner = User::factory()->create();
        MissionCompletion::factory()->for($learner)->create(['xp' => 50, 'created_at' => '2026-10-09 18:00']);
        $learner->xpAwards()->create(['xp' => 20, 'source' => 'review']);
        $learner->load(['missionCompletions', 'xpAwards']);

        expect($learner->streak())->toBe(2);
    });
});

describe('daily goal', function () {
    beforeEach(function () {
        $this->travelTo('2026-10-09 09:00');
    });

    it('adds up only the XP earned today', function () {
        $learner = User::factory()->create();
        MissionCompletion::factory()->for($learner)->create(['xp' => 30, 'created_at' => '2026-10-09 08:00']);
        MissionCompletion::factory()->for($learner)->create(['xp' => 70, 'created_at' => '2026-10-08 20:00']);

        expect($learner->load('missionCompletions')->xpEarnedToday())->toBe(30);
    });

    it('is reached once the daily goal XP is earned', function () {
        $learner = User::factory()->create();
        MissionCompletion::factory()->for($learner)->create(['xp' => User::DAILY_GOAL_XP, 'created_at' => '2026-10-09 08:00']);

        expect($learner->load('missionCompletions')->reachedDailyGoal())->toBeTrue();
    });
});

it('sums the XP earned on each of the last seven days', function () {
    $this->travelTo('2026-10-09 09:00');
    $learner = User::factory()->create();
    MissionCompletion::factory()->for($learner)->create(['xp' => 50, 'created_at' => '2026-10-09 08:00']);
    MissionCompletion::factory()->for($learner)->create(['xp' => 10, 'created_at' => '2026-10-09 08:30']);
    MissionCompletion::factory()->for($learner)->create(['xp' => 60, 'created_at' => '2026-10-07 20:00']);
    MissionCompletion::factory()->for($learner)->create(['xp' => 70, 'created_at' => '2026-10-01 20:00']);

    $xpByDay = array_map(fn (array $day) => [$day['date']->toDateString(), $day['xp']], $learner->dailyXp(7));

    expect($xpByDay)->toBe([
        ['2026-10-03', 0],
        ['2026-10-04', 0],
        ['2026-10-05', 0],
        ['2026-10-06', 0],
        ['2026-10-07', 60],
        ['2026-10-08', 0],
        ['2026-10-09', 60],
    ]);
});
