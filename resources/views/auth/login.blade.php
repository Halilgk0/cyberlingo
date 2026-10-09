<x-layouts.app title="Giriş yap">
    <div class="mx-auto grid max-w-4xl items-center gap-8 py-10 sm:py-14 md:grid-cols-[1fr_18rem]">
        <form method="POST" action="{{ route('login') }}" class="bg-card border-line rise-in order-2 flex flex-col gap-5 rounded-[1.75rem] border-2 p-6 sm:p-8 md:order-1">
            @csrf

            <div>
                <h1 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Tekrar hoş geldin</h1>
                <p class="text-muted mt-2 leading-relaxed">Kaldığın yerden devam et. Serin seni bekliyor!</p>
            </div>

            <x-input-field name="email" type="email" label="E-posta" autocomplete="email" required autofocus />
            <x-input-field name="password" type="password" label="Parola" autocomplete="current-password" required />

            <label class="flex items-center gap-3 font-bold">
                <input type="checkbox" name="remember" value="1" class="accent-safe size-5">
                Beni bu cihazda hatırla
            </label>

            <button type="submit" class="btn-primary mt-2 w-full py-4 text-lg">Giriş yap</button>

            <p class="text-muted text-center">
                Hesabın yok mu?
                <a href="{{ route('register') }}" class="text-safe font-bold underline decoration-2 underline-offset-4">Ücretsiz kayıt ol</a>
            </p>
        </form>

        <div class="order-1 flex items-end justify-center gap-2 md:order-2 md:flex-col md:items-center">
            <x-speech-bubble tail="bottom" class="float mb-3 max-w-[14rem] font-bold leading-snug">
                Seni gördüğüme sevindim! Ortak bilgisayardaysan “beni hatırla”yı işaretleme.
            </x-speech-bubble>
            <x-mascot mood="wave" class="size-28 shrink-0 md:size-44" />
        </div>
    </div>
</x-layouts.app>
