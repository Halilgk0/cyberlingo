<?php

use App\Enums\Rank;

test('the rank is the highest one whose XP threshold has been reached', function (int $xp, Rank $rank) {
    expect(Rank::forXp($xp))->toBe($rank);
})->with([
    'no XP yet' => [0, Rank::Apprentice],
    'just below the second rank' => [99, Rank::Apprentice],
    'exactly on the second rank' => [100, Rank::Squire],
    'far beyond the last rank' => [5000, Rank::Hero],
]);

test('progress towards the next rank is a percentage of the gap between ranks', function () {
    expect(Rank::Squire->progressFor(175))->toBe(50)
        ->and(Rank::Apprentice->progressFor(0))->toBe(0);
});

test('the last rank is always complete', function () {
    expect(Rank::Hero->progressFor(1000))->toBe(100)
        ->and(Rank::Hero->next())->toBeNull();
});
