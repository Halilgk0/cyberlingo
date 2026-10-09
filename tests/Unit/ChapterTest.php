<?php

use App\Enums\Chapter;
use App\Enums\Mission;

test('reading the chapters in order walks every mission once, in path order', function () {
    $missionsByChapter = array_merge(...array_map(fn (Chapter $chapter) => $chapter->missions(), Chapter::cases()));

    expect($missionsByChapter)->toBe(Mission::cases());
});

test('every chapter has at least one mission', function () {
    $missionCounts = array_map(fn (Chapter $chapter) => count($chapter->missions()), Chapter::cases());

    expect($missionCounts)->each->toBeGreaterThan(0);
});

test('chapters are numbered by their position on the learning path, also in Roman numerals', function () {
    expect(Chapter::Basics->number())->toBe(1)
        ->and(Chapter::DataAndConnections->number())->toBe(5)
        ->and(Chapter::Traps->numeral())->toBe('III')
        ->and(Chapter::DataAndConnections->numeral())->toBe('V')
        ->and(Chapter::Crisis->numeral())->toBe('VI');
});
