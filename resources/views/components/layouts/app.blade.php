@props(['title' => null, 'focused' => false])

{{--
    The page shell. `$learner` (the logged-in user, or null) comes from a view composer.
    A `focused` page, such as a mission, drops the site navigation and brings its own `header`.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0c0b0f">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="manifest" href="/manifest.webmanifest">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
        <meta name="description" content="Siber güvenliği oyun gibi öğren: hiçbir şey bilmeyenler için Türkçe, interaktif görevler.">

        <title>{{ $title ? $title.' | '.config('app.name') : config('app.name') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-paper text-ink min-h-screen font-sans antialiased">
        @if ($focused)
            {{ $header ?? '' }}
        @else
            <header class="border-signal/15 bg-paper/85 sticky top-0 z-30 border-b backdrop-blur print:hidden">
                <div class="mx-auto flex max-w-5xl items-center gap-2 px-4 py-2.5 sm:px-6">
                    <a href="{{ route('missions.index') }}" class="font-display focus-visible:outline-ink mr-2 flex items-center gap-2 rounded-md text-3xl font-extrabold focus-visible:outline-2 focus-visible:outline-offset-4">
                        <x-icons.shield class="text-signal size-7" />
                        {{ config('app.name') }}
                    </a>

                    <nav aria-label="Ana menü" class="hidden items-center gap-1 md:flex">
                        <x-nav-item :href="route('missions.index')" icon="icons.path" :active="request()->routeIs('missions.*')">Öğren</x-nav-item>
                        @auth
                            <x-nav-item :href="route('leaderboard')" icon="icons.trophy" :active="request()->routeIs('leaderboard')">Sıralama</x-nav-item>
                        @endauth
                        <x-nav-item :href="route('glossary')" icon="icons.book" :active="request()->routeIs('glossary')">Sözlük</x-nav-item>
                    </nav>

                    <div class="ml-auto flex items-center gap-1 sm:gap-2">
                        @if ($learner)
                            <a href="{{ route('profile.show') }}" title="Günlük seri: {{ $learner->streak() }} gün" class="hover:bg-ink/5 flex items-center gap-1 rounded-xl px-2 py-1.5 text-lg font-extrabold">
                                <x-icons.flame @class(['size-6', 'flame text-[#ff9a3c]' => $learner->hasPracticedToday(), 'text-muted' => ! $learner->hasPracticedToday()]) />
                                <span class="sr-only">Günlük seri:</span> {{ $learner->streak() }}
                            </a>
                            <a href="{{ route('profile.show') }}" title="Toplam XP" class="text-signal hover:bg-ink/5 flex items-center gap-1 rounded-xl px-2 py-1.5 text-lg font-extrabold">
                                <x-icons.bolt class="size-6" />
                                <span class="sr-only">Toplam XP:</span> {{ $learner->totalXp() }}
                            </a>
                            <a href="{{ route('profile.show') }}" class="hover:bg-ink/5 focus-visible:outline-ink hidden rounded-full p-0.5 focus-visible:outline-2 md:block" aria-label="Profilim">
                                <x-mascot :color="$learner->avatar_color" class="size-10" />
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary px-3 py-1.5 text-sm">Giriş yap</a>
                            <a href="{{ route('register') }}" class="btn-primary hidden px-4 py-2 text-sm sm:inline-flex">Ücretsiz kayıt ol</a>
                        @endif
                    </div>
                </div>
            </header>
        @endif

        @if (session('status'))
            <div data-toast role="status" class="toast-in fixed inset-x-0 top-20 z-50 flex justify-center px-4 print:hidden">
                <div class="bg-card border-line flex max-w-md items-center gap-3 rounded-2xl border-2 py-2 pr-2 pl-3 shadow-[0_18px_40px_-12px_rgb(0_0_0/0.7)]">
                    <x-mascot :color="$learner?->avatar_color" mood="wave" class="size-12 shrink-0" />
                    <p class="font-bold leading-snug">{{ session('status') }}</p>
                    <button type="button" data-toast-close class="text-muted hover:text-ink hover:bg-ink/5 shrink-0 rounded-lg p-1.5" aria-label="Bildirimi kapat">
                        <x-icons.close class="size-5" />
                    </button>
                </div>
            </div>
        @endif

        <main @class(['mx-auto max-w-5xl px-4 sm:px-6', 'pb-28 md:pb-20' => ! $focused, 'pb-40' => $focused])>
            {{ $slot }}
        </main>

        @unless ($focused)
            <nav aria-label="Ana menü" class="border-signal/15 bg-paper/95 fixed inset-x-0 bottom-0 print:hidden z-30 flex gap-1 border-t px-2 pt-1.5 pb-[max(0.375rem,env(safe-area-inset-bottom))] backdrop-blur md:hidden">
                <x-nav-item compact :href="route('missions.index')" icon="icons.path" :active="request()->routeIs('missions.*')">Öğren</x-nav-item>
                @auth
                    <x-nav-item compact :href="route('leaderboard')" icon="icons.trophy" :active="request()->routeIs('leaderboard')">Sıralama</x-nav-item>
                @endauth
                <x-nav-item compact :href="route('glossary')" icon="icons.book" :active="request()->routeIs('glossary')">Sözlük</x-nav-item>
                @auth
                    <x-nav-item compact :href="route('profile.show')" icon="icons.user" :active="request()->routeIs('profile.*')">Profil</x-nav-item>
                @else
                    <x-nav-item compact :href="route('register')" icon="icons.user" :active="request()->routeIs('register', 'login')">Hesap</x-nav-item>
                @endauth
            </nav>
        @endunless
    </body>
</html>
