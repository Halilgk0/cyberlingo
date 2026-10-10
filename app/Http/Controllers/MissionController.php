<?php

namespace App\Http\Controllers;

use App\Enums\Chapter;
use App\Enums\Mission;
use App\Enums\MissionState;
use App\Http\GuestProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MissionController extends Controller
{
    /**
     * The learning path: every mission in order, completed, open or still locked.
     */
    public function index(Request $request): View
    {
        $learner = $request->user()?->load(['missionCompletions', 'xpAwards']);
        $completedMissions = $learner?->completedMissions() ?? GuestProgress::missions($request->session());
        $nextMission = collect(Mission::cases())->first(fn (Mission $mission) => ! in_array($mission, $completedMissions, true));
        $currentMission = $nextMission !== null && Gate::allows('start-mission', $nextMission) ? $nextMission : null;

        return view('missions.index', [
            'learner' => $learner,
            'chapters' => Chapter::cases(),
            'currentMission' => $currentMission,
            'completedCount' => count($completedMissions),
            'missionCount' => count(Mission::cases()),
            'states' => collect(Mission::cases())->mapWithKeys(fn (Mission $mission) => [
                $mission->value => match (true) {
                    in_array($mission, $completedMissions, true) => MissionState::Completed,
                    $mission === $currentMission => MissionState::Current,
                    default => MissionState::Locked,
                },
            ])->all(),
        ]);
    }

    public function show(Request $request, Mission $mission): View|RedirectResponse
    {
        if (Gate::allows('start-mission', $mission)) {
            return view($mission->view(), [
                'mission' => $mission,
            ]);
        }

        if ($request->user() === null) {
            return redirect()->route('register')
                ->with('status', 'Bu görevi açmak için ücretsiz bir hesap oluştur. Bitirdiğin görevler hesabına aktarılır.');
        }

        return redirect()->route('missions.index')
            ->with('status', "“{$mission->title()}” henüz kilitli. Önce sıradaki görevini bitir: “{$request->user()->currentMission()?->title()}”.");
    }
}
