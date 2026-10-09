<?php

namespace Database\Factories;

use App\Enums\Mission;
use App\Models\MissionCompletion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MissionCompletion>
 */
class MissionCompletionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mission = fake()->randomElement(Mission::cases());

        return [
            'user_id' => User::factory(),
            'mission' => $mission,
            'xp' => $mission->xp(),
        ];
    }

    /**
     * A first completion of the given mission, worth its full XP.
     */
    public function of(Mission $mission): static
    {
        return $this->state(fn (array $attributes) => [
            'mission' => $mission,
            'xp' => $mission->xp(),
        ]);
    }
}
