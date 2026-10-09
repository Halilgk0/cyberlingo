<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * How many learners the weekly leaderboard lists.
     */
    private const SIZE = 20;

    /**
     * Learners ranked by the XP they earned in the last seven days.
     */
    public function index(Request $request): View
    {
        $weekStart = now()->subDays(7);
        $earnedThisWeek = fn (Builder $completions) => $completions->where('created_at', '>=', $weekStart);

        return view('leaderboard.index', [
            'me' => $request->user(),
            'leaders' => User::query()
                ->select(['id', 'name', 'avatar_color'])
                ->whereHas('missionCompletions', $earnedThisWeek)
                ->withSum(['missionCompletions as weekly_xp' => $earnedThisWeek], 'xp')
                ->orderByDesc('weekly_xp')
                ->orderBy('id')
                ->limit(self::SIZE)
                ->get(),
        ]);
    }
}
