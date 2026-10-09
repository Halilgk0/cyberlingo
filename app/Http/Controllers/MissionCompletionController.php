<?php

namespace App\Http\Controllers;

use App\Enums\Achievement;
use App\Enums\Mission;
use App\Http\GuestProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MissionCompletionController extends Controller
{
    /**
     * Records that the visitor finished a mission and returns what the celebration screen shows.
     */
    public function store(Request $request, Mission $mission): JsonResponse
    {
        Gate::authorize('start-mission', $mission);

        $learner = $request->user()?->load('missionCompletions');

        if ($learner === null) {
            GuestProgress::add($request->session(), $mission);

            return response()->json([
                'guest' => true,
                'xpEarned' => $mission->xp(),
                'registerUrl' => route('register'),
                'pathUrl' => route('missions.index'),
            ]);
        }

        $rankBefore = $learner->rank();
        $achievementsBefore = $learner->earnedAchievements();
        $xpEarned = $learner->completeMission($mission);
        $rank = $learner->rank();
        $nextMission = $mission->next();

        return response()->json([
            'guest' => false,
            'xpEarned' => $xpEarned,
            'totalXp' => $learner->totalXp(),
            'streak' => $learner->streak(),
            'rank' => [
                'title' => $rank->title(),
                'level' => $rank->level(),
                'progress' => $rank->progressFor($learner->totalXp()),
                'nextTitle' => $rank->next()?->title(),
                'rankedUp' => $rank !== $rankBefore,
            ],
            'achievements' => array_values(array_map(
                fn (Achievement $achievement) => [
                    'title' => $achievement->title(),
                    'description' => $achievement->description(),
                    'emoji' => $achievement->emoji(),
                ],
                array_filter(
                    $learner->earnedAchievements(),
                    fn (Achievement $achievement) => ! in_array($achievement, $achievementsBefore, true),
                ),
            )),
            'next' => $nextMission === null ? null : [
                'url' => route('missions.show', $nextMission),
                'title' => $nextMission->title(),
            ],
            'pathUrl' => route('missions.index'),
            'certificateUrl' => count($learner->completedMissions()) === count(Mission::cases()) ? route('certificate') : null,
        ]);
    }
}
