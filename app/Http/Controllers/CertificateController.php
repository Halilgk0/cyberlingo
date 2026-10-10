<?php

namespace App\Http\Controllers;

use App\Enums\Mission;
use App\Models\MissionCompletion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * The Cyber Knight certificate, awarded once every mission on the path is completed.
     * Until then the page shows what is left.
     */
    public function show(Request $request): View
    {
        $learner = $request->user()->load(['missionCompletions', 'xpAwards']);
        $completedMissions = $learner->completedMissions();
        $isEarned = count($completedMissions) === count(Mission::cases());

        return view('certificate.show', [
            'learner' => $learner,
            'isEarned' => $isEarned,
            'completedCount' => count($completedMissions),
            'remainingMissions' => array_values(array_filter(
                Mission::cases(),
                fn (Mission $mission) => ! in_array($mission, $completedMissions, true),
            )),
            /* The day the last mission was finished for the first time. */
            'earnedAt' => $isEarned
                ? $learner->missionCompletions
                    ->groupBy(fn (MissionCompletion $completion) => $completion->mission->value)
                    ->map(fn ($completions) => $completions->min('created_at'))
                    ->max()
                : null,
        ]);
    }
}
