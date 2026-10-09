<?php

use App\Enums\AvatarColor;
use App\Enums\Mission;
use App\Models\User;

it('sends a guest to the login page', function () {
    $this->get(route('profile.show'))->assertRedirect(route('login'));
});

it('shows the learner their level, badges and completed missions', function () {
    $learner = User::factory()->completed(Mission::SecurityBasics, Mission::CastleDefense, Mission::StrongPassword)->create(['name' => 'Ayşe']);

    $response = $this->actingAs($learner)->get(route('profile.show'));

    $response->assertOk()
        ->assertSee('Ayşe')
        ->assertSee('Seviye 2 · Yaver')
        ->assertSee('İlk adım')
        ->assertSeeInOrder(['Tamamlanan görevler', '1. Siber güvenliğe ilk adım', '2. Kaleni katman katman savun', '3. Güçlü bir parola oluştur']);
});

it('updates the name and the mascot color', function () {
    $learner = User::factory()->create(['avatar_color' => AvatarColor::Mint]);

    $response = $this->actingAs($learner)->patch(route('profile.update'), ['name' => 'Yeni Ad', 'avatar_color' => 'violet']);

    $response->assertRedirect(route('profile.show'));
    expect($learner->fresh())
        ->name->toBe('Yeni Ad')
        ->avatar_color->toBe(AvatarColor::Violet);
});

it('rejects a mascot color that does not exist', function () {
    $learner = User::factory()->create(['avatar_color' => AvatarColor::Mint]);

    $response = $this->actingAs($learner)->patch(route('profile.update'), ['name' => 'Ayşe', 'avatar_color' => 'gold']);

    $response->assertSessionHasErrors('avatar_color');
    expect($learner->fresh()->avatar_color)->toBe(AvatarColor::Mint);
});

it('deletes the account and its progress after the password is confirmed', function () {
    $learner = User::factory()->completed(Mission::SecurityBasics)->create();

    $response = $this->actingAs($learner)->delete(route('profile.destroy'), ['password' => 'password']);

    $response->assertRedirect(route('missions.index'));
    $this->assertGuest();
    $this->assertModelMissing($learner);
    $this->assertDatabaseCount('mission_completions', 0);
});

it('keeps the account when the password is wrong', function () {
    $learner = User::factory()->create();

    $response = $this->actingAs($learner)->delete(route('profile.destroy'), ['password' => 'yanlis-parola']);

    $response->assertSessionHasErrorsIn('deleteAccount', 'password');
    $this->assertModelExists($learner);
    $this->assertAuthenticatedAs($learner);
});
