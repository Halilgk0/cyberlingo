<?php

use App\Enums\Mission;
use App\Models\User;

it('renders the login form', function () {
    $this->get(route('login'))->assertOk()->assertSee('Tekrar hoş geldin');
});

it('logs a learner in with the right password', function () {
    $learner = User::factory()->create();

    $response = $this->post(route('login'), ['email' => $learner->email, 'password' => 'password']);

    $response->assertRedirect(route('missions.index'));
    $this->assertAuthenticatedAs($learner);
});

it('rejects a wrong password without saying which field was wrong', function () {
    $learner = User::factory()->create();

    $response = $this->post(route('login'), ['email' => $learner->email, 'password' => 'yanlis-parola']);

    $response->assertSessionHasErrors(['email' => 'E-posta ya da parola hatalı.']);
    $this->assertGuest();
});

it('stops accepting guesses after five wrong passwords', function () {
    $learner = User::factory()->create();

    foreach (range(1, 5) as $attempt) {
        $this->post(route('login'), ['email' => $learner->email, 'password' => "tahmin-{$attempt}"]);
    }

    $response = $this->post(route('login'), ['email' => $learner->email, 'password' => 'password']);

    $response->assertSessionHasErrors('email');
    expect(session('errors')->first('email'))->toStartWith('Çok fazla hatalı deneme yapıldı.');
    $this->assertGuest();
});

it('moves the missions finished as a guest to the account on login', function () {
    $learner = User::factory()->create();
    $this->withSession(['guest_completed_missions' => [Mission::SecurityBasics->value]]);

    $this->post(route('login'), ['email' => $learner->email, 'password' => 'password']);

    expect($learner->fresh()->completedMissions())->toBe([Mission::SecurityBasics]);
});

it('logs the learner out', function () {
    $this->actingAs(User::factory()->create())->post(route('logout'))->assertRedirect(route('missions.index'));

    $this->assertGuest();
});
