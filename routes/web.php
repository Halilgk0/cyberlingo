<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MissionCompletionController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MissionController::class, 'index'])->name('missions.index');
Route::get('/gorevler/{mission}', [MissionController::class, 'show'])->name('missions.show');
Route::post('/gorevler/{mission}/tamamla', [MissionCompletionController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('missions.completions.store');
Route::view('/sozluk', 'glossary')->name('glossary');

Route::middleware('guest')->group(function () {
    Route::get('/kayit', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/kayit', [RegisteredUserController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/giris', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/giris', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/cikis', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/siralama', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/berat', [CertificateController::class, 'show'])->name('certificate');
});
