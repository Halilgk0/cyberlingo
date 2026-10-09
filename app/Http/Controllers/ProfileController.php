<?php

namespace App\Http\Controllers;

use App\Enums\Achievement;
use App\Enums\AvatarColor;
use App\Enums\Mission;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\MissionCompletion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $learner = $request->user()->load('missionCompletions');
        $completionsByMission = $learner->missionCompletions->groupBy(fn (MissionCompletion $completion) => $completion->mission->value);

        return view('profile.show', [
            'learner' => $learner,
            'achievements' => Achievement::cases(),
            'earnedAchievements' => $learner->earnedAchievements(),
            'avatarColors' => AvatarColor::cases(),
            'missionCount' => count(Mission::cases()),
            'history' => array_map(fn (Mission $mission) => [
                'mission' => $mission,
                'firstCompletedAt' => $completionsByMission[$mission->value]->min('created_at'),
                'plays' => $completionsByMission[$mission->value]->count(),
                'xp' => (int) $completionsByMission[$mission->value]->sum('xp'),
            ], $learner->completedMissions()),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return redirect()->route('profile.show')->with('status', 'Profilin güncellendi.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('deleteAccount', [
            'password' => ['required', 'current_password'],
        ]);

        $learner = $request->user();

        Auth::logout();
        $learner->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('missions.index')->with('status', 'Hesabın ve bütün ilerlemen silindi.');
    }
}
