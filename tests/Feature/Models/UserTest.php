<?php

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

    it('drops to zero once a whole day is missed', function () {
        expect(learnerActiveOn('2026-10-05', '2026-10-06', '2026-10-07')->streak())->toBe(0);
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
