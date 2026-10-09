<?php

namespace Database\Seeders;

use App\Enums\Mission;
use App\Models\MissionCompletion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        /* A handful of learners at different points of the path, so the weekly leaderboard has company. */
        foreach (['Deniz' => 7, 'Mert' => 5, 'Zeynep' => 4, 'Can' => 3, 'Elif' => 2] as $name => $missionCount) {
            $learner = User::factory()->create(['name' => $name]);

            foreach (array_slice(Mission::cases(), 0, $missionCount) as $index => $mission) {
                MissionCompletion::factory()->for($learner)->of($mission)->create([
                    'created_at' => now()->subDays($missionCount - $index - 1)->setTime(19, 0),
                ]);
            }
        }
    }
}
