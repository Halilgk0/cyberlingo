<?php

use App\Enums\Chapter;
use App\Enums\Mission;
use App\Enums\MissionKind;

test('missions are numbered by their position on the learning path', function () {
    expect(Mission::SecurityBasics->number())->toBe(1)
        ->and(Mission::CastleDefense->number())->toBe(2)
        ->and(Mission::PasswordVault->number())->toBe(5)
        ->and(Mission::PhishingDragon->number())->toBe(10)
        ->and(Mission::Backups->number())->toBe(16)
        ->and(Mission::DataBreach->number())->toBe(17)
        ->and(Mission::EthicalHacking->number())->toBe(20)
        ->and(Mission::FinalSiege->number())->toBe(23);
});

test('each mission leads to the next one on the learning path', function () {
    expect(Mission::SecurityBasics->next())->toBe(Mission::CastleDefense)
        ->and(Mission::FakeShop->next())->toBe(Mission::PhishingDragon)
        ->and(Mission::PhishingDragon->next())->toBe(Mission::Oversharing);
});

test('the last mission has no next mission', function () {
    expect(Mission::FinalSiege->next())->toBeNull();
});

test('missions belong to the chapter that teaches their topic', function () {
    expect(Mission::SecurityBasics->chapter())->toBe(Chapter::Basics)
        ->and(Mission::TwoFactor->chapter())->toBe(Chapter::Accounts)
        ->and(Mission::PhishingDragon->chapter())->toBe(Chapter::Traps)
        ->and(Mission::AppPermissions->chapter())->toBe(Chapter::Privacy)
        ->and(Mission::Backups->chapter())->toBe(Chapter::DataAndConnections)
        ->and(Mission::LostPhone->chapter())->toBe(Chapter::Crisis)
        ->and(Mission::SecureCode->chapter())->toBe(Chapter::EthicalHacking)
        ->and(Mission::FinalSiege->chapter())->toBe(Chapter::EthicalHacking);
});

test('interludes are short lessons and the dragon trial pays a bonus', function () {
    expect(Mission::CastleDefense->kind())->toBe(MissionKind::Interlude)
        ->and(Mission::CastleDefense->xp())->toBe(40)
        ->and(Mission::LostPhone->kind())->toBe(MissionKind::Interlude)
        ->and(Mission::PhishingDragon->kind())->toBe(MissionKind::Challenge)
        ->and(Mission::PhishingDragon->xp())->toBe(130)
        ->and(Mission::Encryption->kind())->toBe(MissionKind::Lesson);
});
