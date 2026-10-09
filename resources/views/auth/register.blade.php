<x-layouts.app title="Kayıt ol">
    <div class="mx-auto grid max-w-4xl items-center gap-8 py-10 sm:py-14 md:grid-cols-[1fr_18rem]">
        <form method="POST" action="{{ route('register') }}" class="bg-card border-line rise-in order-2 flex flex-col gap-5 rounded-[1.75rem] border-2 p-6 sm:p-8 md:order-1">
            @csrf

            <div>
                <h1 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Hesabını oluştur</h1>
                <p class="text-muted mt-2 leading-relaxed">Ücretsiz. XP’n, serin ve rozetlerin kaydedilsin, görevlerin sırayla açılsın.</p>
            </div>

            @if ($guestMissionCount > 0)
                <p class="border-safe bg-safe/10 rounded-xl border-l-4 px-4 py-3 font-bold">
                    Misafir olarak bitirdiğin {{ $guestMissionCount }} görev, XP’siyle birlikte hesabına aktarılacak.
                </p>
            @endif

            <x-input-field name="name" label="Adın" autocomplete="nickname" maxlength="40" required autofocus hint="Sıralamada bu ad görünür. Gerçek adını yazmak zorunda değilsin." />
            <x-input-field name="email" type="email" label="E-posta" autocomplete="email" required />
            <x-input-field
                name="password"
                type="password"
                label="Parola"
                autocomplete="new-password"
                minlength="12"
                required
                hint="En az 12 karakter. Parola görevindeki gibi bir parola cümlesi dene: birbiriyle ilgisiz dört kelime ve bir rakam."
            />
            <x-input-field name="password_confirmation" type="password" label="Parola (tekrar)" autocomplete="new-password" required />

            <button type="submit" class="btn-primary mt-2 w-full py-4 text-lg">Hesap oluştur</button>

            <p class="text-muted text-center">
                Zaten hesabın var mı?
                <a href="{{ route('login') }}" class="text-safe font-bold underline decoration-2 underline-offset-4">Giriş yap</a>
            </p>
        </form>

        <div class="order-1 flex items-end justify-center gap-2 md:order-2 md:flex-col md:items-center">
            <x-speech-bubble tail="bottom" class="float mb-3 max-w-[14rem] font-bold leading-snug">
                Harika bir karar! Birlikte güçlü bir parola seçelim.
            </x-speech-bubble>
            <x-mascot mood="cheer" class="size-28 shrink-0 md:size-44" />
        </div>
    </div>
</x-layouts.app>
