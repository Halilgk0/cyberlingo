<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResolveReviewRequest;
use App\Http\Requests\StoreReviewItemRequest;
use App\Models\ReviewItem;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * How many questions a single review session serves.
     */
    private const SESSION_SIZE = 15;

    public function show(Request $request): View
    {
        $learner = $request->user();

        $due = $learner->reviewItems()->due()->orderBy('due_on')->limit(self::SESSION_SIZE)->get();
        $laterCount = $learner->reviewItems()->whereDate('due_on', '>', CarbonImmutable::today())->count();

        return view('review.show', [
            'learner' => $learner,
            'items' => $due->map(fn (ReviewItem $item) => ['key' => $item->key] + $item->data)->all(),
            'laterCount' => $laterCount,
        ]);
    }

    /**
     * Adds a missed question to the notebook, due for review tomorrow. Re-missing a known
     * question refreshes its snapshot and reschedules it.
     */
    public function store(StoreReviewItemRequest $request): JsonResponse
    {
        $data = $request->safe()->except('key');

        $request->user()->reviewItems()->updateOrCreate(
            ['key' => $request->validated('key')],
            ['data' => $data, 'due_on' => CarbonImmutable::tomorrow()],
        );

        return response()->json(['ok' => true], 201);
    }

    /**
     * Drops the questions the learner got right and reschedules the ones they missed again.
     */
    public function resolve(ResolveReviewRequest $request): JsonResponse
    {
        $learner = $request->user()->load('xpAwards');
        $correct = $request->validated('correct', []);
        $wrong = $request->validated('wrong', []);

        $learner->reviewItems()->whereIn('key', $correct)->delete();
        $learner->reviewItems()->whereIn('key', $wrong)->update(['due_on' => CarbonImmutable::tomorrow()]);

        // A finished review session is worth a small bonus, at most once a day, so it
        // counts towards the daily goal and the streak without being farmable.
        $xpEarned = 0;

        if (count($correct) + count($wrong) > 0 && ! $learner->earnedReviewBonusToday()) {
            $learner->xpAwards()->create(['xp' => User::REVIEW_XP, 'source' => 'review']);
            $xpEarned = User::REVIEW_XP;
        }

        return response()->json([
            'remaining' => $learner->reviewItems()->due()->count(),
            'xpEarned' => $xpEarned,
        ]);
    }
}
