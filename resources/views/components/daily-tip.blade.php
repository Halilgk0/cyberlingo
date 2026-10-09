@php
    /* One short habit a day, the same for everyone on a given date. */
    $tips = [
        'Telefonuna gelen doğrulama kodunu hiçbir kurum istemez. İsteyen herkes dolandırıcıdır.',
        'Bir bağlantıya tıklamadan önce alan adını bul: ilk eğik çizgiden sola doğru oku.',
        'Güncellemeleri erteleme; çoğu güncelleme bilinen bir güvenlik açığını kapatır.',
        'Her hesapta farklı bir parola kullan; hepsini bir parola kasası hatırlasın.',
        'E-posta hesabında iki adımlı doğrulamayı aç: diğer hesaplarının anahtarı odur.',
        'Tatil fotoğraflarını eve dönünce paylaş; evin boş olduğunu herkes bilmesin.',
        'Halka açık Wi-Fi’da bankacılık için Wi-Fi’ı kapat, mobil veriyi kullan.',
        'Önemli dosyalarının en az bir kopyası evin dışında, örneğin bulutta dursun.',
        'Uygulama izinlerini ayda bir gözden geçir; kullanmadığın uygulamaları sil.',
        '“fatura.pdf.exe” gibi çift uzantılı eklere dikkat: bunlar belge değil, programdır.',
        'Acele ettiren her mesajda dur: dolandırıcıların en sevdiği silah zaman baskısıdır.',
        'Tanıdığın biri yeni bir numaradan para isterse onu eski numarasından ara.',
        'Güvenlik sorularına gerçek cevaplar yerine rastgele cevaplar yaz ve kasanda sakla.',
        'Masadan kalkarken ekranını kilitle; açık bir ekranın tek fotoğrafı her şeyi anlatabilir.',
        'Telefonunda “Cihazımı bul” özelliğinin açık olduğunu bugün kontrol et; telefon kaybolduktan sonra açılamaz.',
        '“Parolanı biliyorum” diyen şantaj e-postalarına para gönderme; o parola eski bir sızıntıdan bulunmuştur.',
        'Hesaplarındaki kurtarma e-postası ve telefon numarası güncel mi? Hesabın ele geçirilirse geri dönüş yolun onlar.',
    ];
    $tip = $tips[now()->dayOfYear % count($tips)];
@endphp

{{-- Today's tip on the learning path, lit like a candle in a dark hall. --}}
<section aria-label="Günün ipucu" {{ $attributes->class(['bg-card border-line riveted relative overflow-hidden rounded-[1.5rem] border-2 p-5']) }}>
    <span aria-hidden="true" class="torch pointer-events-none absolute -top-10 -right-10 size-32 rounded-full bg-[radial-gradient(circle,rgb(255_138_61/0.22),transparent_70%)]"></span>
    <p class="rune-label text-signal relative flex items-center gap-2 text-xs">
        <x-icons.flame class="flame size-4 text-[#ff9a3c]" /> Günün ipucu
    </p>
    <p class="relative mt-2 leading-relaxed">{{ $tip }}</p>
</section>
