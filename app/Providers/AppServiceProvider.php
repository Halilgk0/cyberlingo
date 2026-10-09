<?php

namespace App\Providers;

use App\Enums\Mission;
use App\Http\GuestProgress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View as ViewInstance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
         * Missions open one by one. Guests can only try the first one;
         * everything after it needs an account.
         */
        Gate::define('start-mission', function (?User $user, Mission $mission): bool {
            return $user?->canStart($mission) ?? $mission->previous() === null;
        });

        /* The strong-password mission teaches 12 characters as the minimum, so the app asks for the same. */
        Password::defaults(fn () => Password::min(12));

        View::composer(['components.layouts.app', 'components.layouts.mission'], function (ViewInstance $view): void {
            $learner = Auth::user()?->loadMissing('missionCompletions');

            $view->with([
                'learner' => $learner,
                'visitorCompletedMissions' => $learner?->completedMissions() ?? GuestProgress::missions(session()->driver()),
            ]);
        });
    }
}
