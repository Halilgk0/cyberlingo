<?php

namespace App\Http;

use App\Enums\Mission;
use Illuminate\Contracts\Session\Session;

/**
 * Missions a visitor finished before having an account. They live in the session
 * until the visitor signs up or logs in, then move to the account.
 */
class GuestProgress
{
    private const SESSION_KEY = 'guest_completed_missions';

    /**
     * @return list<Mission>
     */
    public static function missions(Session $session): array
    {
        return array_values(array_filter(
            array_map(fn (string $value) => Mission::tryFrom($value), $session->get(self::SESSION_KEY, [])),
        ));
    }

    public static function add(Session $session, Mission $mission): void
    {
        $values = $session->get(self::SESSION_KEY, []);

        if (! in_array($mission->value, $values, true)) {
            $session->put(self::SESSION_KEY, [...$values, $mission->value]);
        }
    }

    /**
     * Takes the guest's missions out of the session, so they are claimed only once.
     *
     * @return list<Mission>
     */
    public static function pull(Session $session): array
    {
        $missions = self::missions($session);

        $session->forget(self::SESSION_KEY);

        return $missions;
    }
}
