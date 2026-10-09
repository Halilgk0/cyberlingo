@props(['code', 'title', 'mood' => 'think', 'actionUrl' => null, 'actionLabel' => 'Öğrenme yoluna dön'])

{{--
    A friendly error page with Bit. It stands alone instead of using the app layout, so it
    still renders when the error came from the database or the session.
--}}
<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0c0b0f">
        <meta name="robots" content="noindex">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <title>{{ $title }} | {{ config('app.name') }}</title>

        @fonts

        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-paper text-ink min-h-screen font-sans antialiased">
        <main class="mx-auto flex min-h-screen max-w-lg flex-col items-center justify-center px-4 py-12 text-center">
            <a href="{{ route('missions.index') }}" class="font-display focus-visible:outline-ink flex items-center gap-2 rounded-md text-3xl font-extrabold focus-visible:outline-2 focus-visible:outline-offset-4">
                <x-icons.shield class="text-signal size-7" />
                {{ config('app.name') }}
            </a>

            <x-mascot :mood="$mood" class="mt-10 size-28 sm:size-32" />

            <p class="font-rune text-signal/70 mt-6 text-sm tracking-[0.3em]">Hata {{ $code }}</p>
            <h1 class="font-display mt-2 text-4xl leading-tight font-extrabold text-balance sm:text-5xl">{{ $title }}</h1>
            <p class="text-muted mt-4 max-w-[42ch] leading-relaxed sm:text-lg">{{ $slot }}</p>

            <a href="{{ $actionUrl ?? route('missions.index') }}" class="btn-primary mt-8 w-full sm:w-auto">{{ $actionLabel }}</a>
        </main>
    </body>
</html>
