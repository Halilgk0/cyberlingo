<?php

use App\Enums\Mission;
use App\Models\User;

it('renders the registration form', function () {
    $this->get(route('register'))->assertOk()->assertSee('Hesabını oluştur');
});

it('creates an account, logs the learner in and sends them to the path', function () {
    $response = $this->post(route('register'), [
        'name' => 'Ayşe',
        'email' => 'ayse@example.com',
        'password' => 'Mavi-Kedi-Sabah-Yuruyor-7',
        'password_confirmation' => 'Mavi-Kedi-Sabah-Yuruyor-7',
    ]);

    $response->assertRedirect(route('missions.index'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', ['name' => 'Ayşe', 'email' => 'ayse@example.com', 'avatar_color' => 'mint']);
});

it('rejects a password shorter than 12 characters', function () {
    $response = $this->from(route('register'))->post(route('register'), [
        'name' => 'Ayşe',
        'email' => 'ayse@example.com',
        'password' => 'kisa-parola',
        'password_confirmation' => 'kisa-parola',
    ]);

    $response->assertRedirect(route('register'))
        ->assertSessionHasErrors(['password' => 'Parola en az 12 karakter olmalı.']);
    $this->assertGuest();
    $this->assertDatabaseCount('users', 0);
});

it('rejects an email that already has an account', function () {
    User::factory()->create(['email' => 'ayse@example.com']);

    $response = $this->post(route('register'), [
        'name' => 'Ayşe',
        'email' => 'ayse@example.com',
        'password' => 'Mavi-Kedi-Sabah-Yuruyor-7',
        'password_confirmation' => 'Mavi-Kedi-Sabah-Yuruyor-7',
    ]);

    $response->assertSessionHasErrors(['email' => 'Bu e-posta ile kayıtlı bir hesap zaten var.']);
    $this->assertGuest();
});

it('moves the missions finished as a guest to the new account', function () {
    $this->withSession(['guest_completed_missions' => [Mission::SecurityBasics->value]]);

    $this->post(route('register'), [
        'name' => 'Ayşe',
        'email' => 'ayse@example.com',
        'password' => 'Mavi-Kedi-Sabah-Yuruyor-7',
        'password_confirmation' => 'Mavi-Kedi-Sabah-Yuruyor-7',
    ]);

    $learner = User::firstWhere('email', 'ayse@example.com');
    expect($learner->completedMissions())->toBe([Mission::SecurityBasics])
        ->and($learner->totalXp())->toBe(50)
        ->and(session('guest_completed_missions'))->toBeNull();
});

it('sends a logged-in learner away from the registration form', function () {
    $this->actingAs(User::factory()->create())->get(route('register'))->assertRedirect('/');
});
