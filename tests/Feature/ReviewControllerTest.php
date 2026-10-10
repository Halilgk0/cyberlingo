<?php

use App\Models\User;
use Carbon\CarbonImmutable;

/**
 * A self-contained question snapshot, like the page sends when a question is missed.
 *
 * @return array<string, mixed>
 */
function questionPayload(string $key = 'guclu-parola:0'): array
{
    return [
        'key' => $key,
        'mission' => 'guclu-parola',
        'missionTitle' => 'Güçlü bir parola oluştur',
        'prompt' => 'Bu parolalardan hangisi en güçlüsü?',
        'code' => null,
        'explanation' => 'Uzun bir parola cümlesi en güçlüsüdür.',
        'options' => [
            ['text' => 'kisa123', 'correct' => false],
            ['text' => 'Ay-Dere-Kalem-Bulut-48', 'correct' => true],
        ],
    ];
}

beforeEach(function () {
    $this->travelTo('2026-10-10 09:00');
});

describe('guests', function () {
    it('sends a guest to login for every review route', function () {
        $this->get(route('review.show'))->assertRedirect(route('login'));
        $this->postJson(route('review.store'), questionPayload())->assertUnauthorized();
        $this->postJson(route('review.resolve'), ['correct' => []])->assertUnauthorized();
    });
});

describe('banking a missed question', function () {
    it('saves a missed question to the notebook, due tomorrow', function () {
        $learner = User::factory()->create();

        $this->actingAs($learner)->postJson(route('review.store'), questionPayload())->assertCreated();

        $item = $learner->reviewItems()->sole();
        expect($item->key)->toBe('guclu-parola:0')
            ->and($item->data['prompt'])->toBe('Bu parolalardan hangisi en güçlüsü?')
            ->and($item->due_on->toDateString())->toBe('2026-10-11');
    });

    it('updates the snapshot instead of duplicating when the same question is missed again', function () {
        $learner = User::factory()->create();

        $this->actingAs($learner)->postJson(route('review.store'), questionPayload())->assertCreated();
        $this->actingAs($learner)->postJson(route('review.store'), [...questionPayload(), 'prompt' => 'Güncellenmiş soru'])->assertCreated();

        expect($learner->reviewItems()->count())->toBe(1)
            ->and($learner->reviewItems()->sole()->data['prompt'])->toBe('Güncellenmiş soru');
    });

    it('rejects a question with fewer than two options', function () {
        $learner = User::factory()->create();

        $response = $this->actingAs($learner)->postJson(route('review.store'), [
            ...questionPayload(),
            'options' => [['text' => 'tek', 'correct' => true]],
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors('options');
        expect($learner->reviewItems()->count())->toBe(0);
    });
});

describe('the review session', function () {
    it('shows only the questions that are due today', function () {
        $learner = User::factory()->create();
        $learner->reviewItems()->create(['key' => 'a', 'data' => [...questionPayload('a'), 'prompt' => 'Bugünkü soru'], 'due_on' => CarbonImmutable::today()]);
        $learner->reviewItems()->create(['key' => 'b', 'data' => [...questionPayload('b'), 'prompt' => 'Yarınki soru'], 'due_on' => CarbonImmutable::tomorrow()]);

        $response = $this->actingAs($learner)->get(route('review.show'));

        $response->assertOk()
            ->assertSee('Bugünkü soru')
            ->assertDontSee('Yarınki soru');
    });

    it('shows a friendly empty state when nothing is due', function () {
        $learner = User::factory()->create();

        $this->actingAs($learner)->get(route('review.show'))->assertOk()->assertSee('Şimdilik tekrar yok');
    });

    it('clears the right answers and reschedules the wrong ones', function () {
        $learner = User::factory()->create();
        $learner->reviewItems()->create(['key' => 'a', 'data' => questionPayload('a'), 'due_on' => CarbonImmutable::today()]);
        $learner->reviewItems()->create(['key' => 'b', 'data' => questionPayload('b'), 'due_on' => CarbonImmutable::today()]);

        $this->actingAs($learner)->postJson(route('review.resolve'), ['correct' => ['a'], 'wrong' => ['b']])
            ->assertOk()->assertJsonPath('remaining', 0);

        expect($learner->reviewItems()->pluck('key')->all())->toBe(['b'])
            ->and($learner->reviewItems()->sole()->due_on->toDateString())->toBe('2026-10-11');
    });

    it('awards a once-a-day XP bonus for finishing a review session', function () {
        $learner = User::factory()->create();
        $learner->reviewItems()->create(['key' => 'a', 'data' => questionPayload('a'), 'due_on' => CarbonImmutable::today()]);

        $this->actingAs($learner)->postJson(route('review.resolve'), ['correct' => ['a'], 'wrong' => []])
            ->assertOk()->assertJsonPath('xpEarned', 20);

        expect($learner->xpAwards()->count())->toBe(1);

        $learner->reviewItems()->create(['key' => 'b', 'data' => questionPayload('b'), 'due_on' => CarbonImmutable::today()]);
        $this->actingAs($learner)->postJson(route('review.resolve'), ['correct' => ['b'], 'wrong' => []])
            ->assertOk()->assertJsonPath('xpEarned', 0);

        expect($learner->xpAwards()->count())->toBe(1);
    });

    it('gives no XP when nothing was answered', function () {
        $learner = User::factory()->create();

        $this->actingAs($learner)->postJson(route('review.resolve'), ['correct' => [], 'wrong' => []])
            ->assertOk()->assertJsonPath('xpEarned', 0);

        expect($learner->xpAwards()->count())->toBe(0);
    });

    it('counts the questions due today', function () {
        $learner = User::factory()->create();
        $learner->reviewItems()->create(['key' => 'a', 'data' => questionPayload('a'), 'due_on' => CarbonImmutable::today()]);
        $learner->reviewItems()->create(['key' => 'b', 'data' => questionPayload('b'), 'due_on' => CarbonImmutable::tomorrow()]);

        expect($learner->dueReviewCount())->toBe(1);
    });
});
