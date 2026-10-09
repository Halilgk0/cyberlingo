<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\GuestProgress;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register', [
            'guestMissionCount' => count(GuestProgress::missions($request->session())),
        ]);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->safe()->only(['name', 'email', 'password']));

        Auth::login($user);
        $request->session()->regenerate();
        $user->claimGuestProgress(GuestProgress::pull($request->session()));

        return redirect()->route('missions.index')
            ->with('status', "Hoş geldin {$user->name}! Hesabın hazır, ilerlemen artık kaydediliyor.");
    }
}
