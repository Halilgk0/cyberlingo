<?php

namespace App\Http\Controllers;

use App\Enums\ChecklistItem;
use App\Http\Requests\UpdateChecklistRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChecklistController extends Controller
{
    public function show(Request $request): View
    {
        $learner = $request->user()->load('missionCompletions');

        return view('checklist.show', [
            'learner' => $learner,
            'groups' => collect(ChecklistItem::cases())->groupBy(fn (ChecklistItem $item) => $item->group()),
            'checkedItems' => $learner->checkedItems(),
        ]);
    }

    /**
     * Saves the ticked items. The page saves each tick in the background and gets JSON back;
     * without JavaScript the form posts normally and comes back to the page.
     */
    public function update(UpdateChecklistRequest $request): JsonResponse|RedirectResponse
    {
        $learner = $request->user();
        $learner->update(['checklist' => array_map(
            fn (string $item) => ChecklistItem::from($item),
            $request->validated('items', []),
        )]);

        if ($request->wantsJson()) {
            return response()->json([
                'checked' => count($learner->checkedItems()),
                'total' => count(ChecklistItem::cases()),
            ]);
        }

        return redirect()->route('checklist.show')->with('status', 'Kontrol listen kaydedildi.');
    }
}
