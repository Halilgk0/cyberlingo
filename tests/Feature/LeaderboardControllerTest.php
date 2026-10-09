<?php

use App\Enums\Mission;
use App\Models\MissionCompletion;
use App\Models\User;

it('sends a guest to the login page', function () {
    $this->get(route('leaderboard'))->assertRedirect(route('login'));
});

it('ranks learners by the XP they earned in the last seven days', function () {
    $this->travelTo('2026-10-09 12:00');
    $leader = User::factory()->create(['name' => 'Lider']);
    $runnerUp = User::factory()->create(['name' => 'İkinci']);
    MissionCompletion::factory()->for($leader)->create(['xp' => 80]);
    MissionCompletion::factory()->for($runnerUp)->create(['xp' => 50]);

    $response = $this->actingAs($runnerUp)->get(route('leaderboard'));

    $response->assertOk()->assertSeeInOrder(['Lider', '80 XP', 'İkinci', '(sen)', '50 XP']);
});

it('leaves out XP earned more than a week ago', function () {
    $this->travelTo('2026-10-01 12:00');
    $veteran = User::factory()->completed(Mission::SecurityBasics)->create(['name' => 'Eski Usta']);
    $this->travelTo('2026-10-09 12:00');

    $response = $this->actingAs($veteran)->get(route('leaderboard'));

    $response->assertOk()
        ->assertDontSee('Eski Usta')
        ->assertSee('Bu hafta henüz kimse XP kazanmadı.');
});
