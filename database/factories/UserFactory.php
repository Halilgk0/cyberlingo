<?php

namespace Database\Factories;

use App\Enums\AvatarColor;
use App\Enums\Mission;
use App\Models\MissionCompletion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'avatar_color' => fake()->randomElement(AvatarColor::cases()),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * A learner who has completed the given missions once each.
     */
    public function completed(Mission ...$missions): static
    {
        return $this->has(
            MissionCompletion::factory()->forEachSequence(
                ...array_map(fn (Mission $mission) => ['mission' => $mission, 'xp' => $mission->xp()], $missions),
            ),
        );
    }
}
