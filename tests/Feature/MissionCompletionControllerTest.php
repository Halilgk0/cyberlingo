<?php

use App\Enums\Chapter;
use App\Enums\Mission;
use App\Models\MissionCompletion;
use App\Models\User;

describe('as a guest', function () {
    it('remembers the first mission in the session without touching the database', function () {
        $response = $this->postJson(route('missions.completions.store', Mission::SecurityBasics));

        $response->assertOk()->assertJson([
            'guest' => true,
            'xpEarned' => 50,
            'registerUrl' => route('register'),
        ]);
        expect(session('guest_completed_missions'))->toBe(['siber-guvenlige-ilk-adim']);
        $this->assertDatabaseCount('mission_completions', 0);
    });

    it('rejects completing any mission after the first with 403', function () {
        $this->postJson(route('missions.completions.store', Mission::StrongPassword))->assertForbidden();

        expect(session('guest_completed_missions'))->toBeNull();
    });
});

describe('as a learner', function () {
    it('awards the full XP and points to the next mission on the first completion', function () {
        $learner = User::factory()->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::SecurityBasics));

        $response->assertOk()->assertJson([
            'guest' => false,
            'xpEarned' => 50,
            'totalXp' => 50,
            'streak' => 1,
            'rank' => ['title' => 'Çırak', 'level' => 1, 'progress' => 50, 'rankedUp' => false],
            'achievements' => [['title' => 'İlk adım']],
            'next' => ['url' => route('missions.show', Mission::CastleDefense), 'title' => 'Kaleni katman katman savun'],
        ]);
        $this->assertDatabaseHas('mission_completions', [
            'user_id' => $learner->id,
            'mission' => 'siber-guvenlige-ilk-adim',
            'xp' => 50,
        ]);
    });

    it('reports a rank up when the completion crosses the next rank threshold', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics, Mission::CastleDefense)->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::StrongPassword));

        $response->assertOk()->assertJson([
            'totalXp' => 140,
            'rank' => ['title' => 'Yaver', 'level' => 2, 'rankedUp' => true],
        ]);
    });

    it('awards no XP and records nothing for a second replay on the same day', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics)->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::SecurityBasics));

        $response->assertOk()->assertJson(['xpEarned' => 0, 'totalXp' => 50]);
        $this->assertDatabaseCount('mission_completions', 1);
    });

    it('awards the replay XP for a mission completed on an earlier day', function () {
        $this->travelTo('2026-10-08 12:00');
        $learner = User::factory()->completed(Mission::SecurityBasics)->create();
        $this->travelTo('2026-10-09 12:00');

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::SecurityBasics));

        $response->assertOk()->assertJson([
            'xpEarned' => Mission::REPLAY_XP,
            'totalXp' => 60,
            'streak' => 2,
            'achievements' => [['title' => 'Pratik yapan']],
        ]);
        expect(MissionCompletion::where('user_id', $learner->id)->count())->toBe(2);
    });

    it('rejects completing a locked mission with 403', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics)->create();

        $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::TwoFactor))->assertForbidden();

        $this->assertDatabaseMissing('mission_completions', ['mission' => Mission::TwoFactor->value]);
    });

    it('points to the certificate instead of a next mission after the last one', function () {
        $learner = User::factory()->completed(...array_slice(Mission::cases(), 0, -1))->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::FinalSiege));

        $response->assertOk()
            ->assertJsonPath('next', null)
            ->assertJsonPath('certificateUrl', route('certificate'))
            ->assertJsonFragment(['title' => 'Siber kahraman']);
    });

    it('offers no certificate while missions are left', function () {
        $learner = User::factory()->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::SecurityBasics));

        $response->assertOk()->assertJsonPath('certificateUrl', null);
    });

    it('announces a chapter on the completion that finishes it', function () {
        $missions = Chapter::Basics->missions();
        $learner = User::factory()->completed(...array_slice($missions, 0, -1))->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', end($missions)));

        $response->assertOk()->assertJsonPath('chapterCompleted', 'Temeller');
    });

    it('does not announce a chapter part-way through it', function () {
        $learner = User::factory()->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::SecurityBasics));

        $response->assertOk()->assertJsonPath('chapterCompleted', null);
    });

    it('does not announce a chapter on a replay that completes nothing new', function () {
        $learner = User::factory()->completed(...Chapter::Basics->missions())->create();

        $response = $this->actingAs($learner)->postJson(route('missions.completions.store', Mission::CastleDefense));

        $response->assertOk()->assertJsonPath('chapterCompleted', null);
    });
});
