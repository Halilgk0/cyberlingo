<?php

use App\Enums\Mission;
use App\Models\User;

it('sends a guest to the login page', function () {
    $this->get(route('certificate'))->assertRedirect(route('login'));
});

it('shows how many missions are left before the certificate is earned', function () {
    $learner = User::factory()->completed(Mission::SecurityBasics, Mission::CastleDefense)->create();

    $response = $this->actingAs($learner)->get(route('certificate'));

    $response->assertOk()
        ->assertSee('Beratın henüz mühürlenmedi')
        ->assertSee('18 görev kaldı')
        ->assertDontSee('Beratı yazdır');
});

it('awards the certificate with the learner name once every mission is completed', function () {
    $this->travelTo('2026-10-09 12:00');
    $learner = User::factory()->completed(...Mission::cases())->create(['name' => 'Ayşe Yılmaz']);

    $response = $this->actingAs($learner)->get(route('certificate'));

    $response->assertOk()
        ->assertSee('Siber Şövalye Beratı')
        ->assertSee('Ayşe Yılmaz')
        ->assertSee('9 Ekim 2026')
        ->assertSee('Beratı yazdır');
});
