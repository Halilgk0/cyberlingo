<?php

use App\Enums\ChecklistItem;
use App\Enums\Mission;
use App\Models\User;

describe('show', function () {
    it('sends a guest to the login page', function () {
        $this->get(route('checklist.show'))->assertRedirect(route('login'));
    });

    it('lists every item with the ones the learner ticked already checked', function () {
        $learner = User::factory()->create(['checklist' => [ChecklistItem::ScreenLock]]);

        $response = $this->actingAs($learner)->get(route('checklist.show'));

        $response->assertOk()
            ->assertSeeInOrder(array_map(fn (ChecklistItem $item) => $item->title(), ChecklistItem::cases()))
            ->assertSee('value="ekran-kilidi" checked', false)
            ->assertDontSee('value="cihazimi-bul" checked', false);
    });

    it('links an item to its mission only once the learner can start that mission', function () {
        $learner = User::factory()->completed(...array_slice(Mission::cases(), 0, 5))->create();

        $response = $this->actingAs($learner)->get(route('checklist.show'));

        $response->assertOk()
            ->assertSee(route('missions.show', Mission::TwoFactor))
            ->assertDontSee(route('missions.show', Mission::LostPhone))
            ->assertSee('Görev '.Mission::LostPhone->number().' açılınca öğreneceksin.');
    });
});

describe('update', function () {
    it('saves the ticked items and reports the progress as JSON', function () {
        $learner = User::factory()->create();

        $response = $this->actingAs($learner)->putJson(route('checklist.update'), [
            'items' => [ChecklistItem::ScreenLock->value, ChecklistItem::EmailTwoFactor->value],
        ]);

        $response->assertOk()->assertExactJson(['checked' => 2, 'total' => count(ChecklistItem::cases())]);
        expect($learner->fresh()->checkedItems())->toBe([ChecklistItem::EmailTwoFactor, ChecklistItem::ScreenLock]);
    });

    it('clears the checklist when nothing is ticked', function () {
        $learner = User::factory()->create(['checklist' => [ChecklistItem::ScreenLock]]);

        $this->actingAs($learner)->putJson(route('checklist.update'))->assertOk()->assertJsonPath('checked', 0);

        expect($learner->fresh()->checkedItems())->toBe([]);
    });

    it('returns to the checklist after a form post without JavaScript', function () {
        $learner = User::factory()->create();

        $response = $this->actingAs($learner)->put(route('checklist.update'), ['items' => [ChecklistItem::OffsiteBackup->value]]);

        $response->assertRedirect(route('checklist.show'))->assertSessionHas('status', 'Kontrol listen kaydedildi.');
        expect($learner->fresh()->checkedItems())->toBe([ChecklistItem::OffsiteBackup]);
    });

    it('rejects an item that is not on the checklist', function () {
        $learner = User::factory()->create(['checklist' => [ChecklistItem::ScreenLock]]);

        $response = $this->actingAs($learner)->putJson(route('checklist.update'), ['items' => ['olmayan-madde']]);

        $response->assertUnprocessable()->assertJsonValidationErrors('items.0');
        expect($learner->fresh()->checkedItems())->toBe([ChecklistItem::ScreenLock]);
    });

    it('rejects a guest', function () {
        $this->putJson(route('checklist.update'), ['items' => [ChecklistItem::ScreenLock->value]])->assertUnauthorized();
    });
});
