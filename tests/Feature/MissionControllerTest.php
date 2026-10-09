<?php

use App\Enums\Mission;
use App\Models\User;

describe('index', function () {
    it('shows the chapters in path order with every mission on the path', function () {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSeeInOrder([
                'Temeller',
                'Siber güvenliğe ilk adım',
                'Kaleni katman katman savun',
                'Hesaplarını koru',
                'Güçlü bir parola oluştur',
                'İki adımlı doğrulamayı kur',
                'Parola kasanı kur',
                'Tuzakları tanı',
                'Bir bağlantının sahibini bul',
                'Oltalama e-postasını yakala',
                'Dolandırıcı mesajlarını tanı',
                'Sahte mağazayı tanı',
                'Ejderha sınavı: Usta oltacı',
                'Mahremiyetini koru',
                'Paylaşmadan önce düşün',
                'Uygulama izinlerini yönet',
                'Verini ve bağlantını koru',
                'Şifrelemenin sırrını çöz',
                'Halka açık Wi-Fi’da güvende kal',
                'Truva atı ve zararlı yazılımlar',
                'Fidye yazılımına karşı yedekle',
                'Kriz anında',
                'Verilerin sızdı: şimdi ne olacak?',
                'Hesabın ele geçirildi: kriz planı',
                'Telefonun kayboldu ya da çalındı',
                'Son sınav: Kale kuşatması',
                'Siber Kale',
            ]);
    });

    it('opens only the first mission to a guest', function () {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee(route('missions.show', Mission::SecurityBasics))
            ->assertDontSee(route('missions.show', Mission::CastleDefense))
            ->assertSee('Ücretsiz hesap oluştur')
            ->assertSee('Günün ipucu');
    });

    it('opens the completed missions and the next one to a learner', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics)->create();

        $response = $this->actingAs($learner)->get('/');

        $response->assertOk()
            ->assertSee(route('missions.show', Mission::SecurityBasics))
            ->assertSee('Devam et: Kaleni katman katman savun')
            ->assertDontSee(route('missions.show', Mission::StrongPassword));
    });
});

describe('show', function () {
    it('renders the mission page', function (string $slug, string $title, string $view) {
        $learner = User::factory()->completed(...Mission::cases())->create();

        $response = $this->actingAs($learner)->get("/gorevler/{$slug}");

        $response->assertOk()
            ->assertViewIs($view)
            ->assertSee($title)
            ->assertSee('Görevi tamamla');
    })->with([
        'security basics' => ['siber-guvenlige-ilk-adim', 'Siber güvenliğe ilk adım', 'missions.security-basics'],
        'castle defense' => ['kale-savunmasi', 'Kaleni katman katman savun', 'missions.castle-defense'],
        'strong password' => ['guclu-parola', 'Güçlü bir parola oluştur', 'missions.strong-password'],
        'two factor' => ['iki-adimli-dogrulama', 'İki adımlı doğrulamayı kur', 'missions.two-factor'],
        'password vault' => ['parola-kasasi', 'Parola kasanı kur', 'missions.password-vault'],
        'reading links' => ['baglantinin-sahibi', 'Bir bağlantının sahibini bul', 'missions.reading-links'],
        'phishing email' => ['oltalama-e-postasi', 'Oltalama e-postasını yakala', 'missions.phishing-email'],
        'scam messages' => ['dolandirici-mesajlari', 'Dolandırıcı mesajlarını tanı', 'missions.scam-messages'],
        'fake shop' => ['sahte-magaza', 'Sahte mağazayı tanı', 'missions.fake-shop'],
        'phishing dragon' => ['ejderha-sinavi-oltalama', 'Ejderha sınavı: Usta oltacı', 'missions.phishing-dragon'],
        'oversharing' => ['paylasmadan-once-dusun', 'Paylaşmadan önce düşün', 'missions.oversharing'],
        'app permissions' => ['uygulama-izinleri', 'Uygulama izinlerini yönet', 'missions.app-permissions'],
        'encryption' => ['sifreleme', 'Şifrelemenin sırrını çöz', 'missions.encryption'],
        'public wifi' => ['halka-acik-wifi', 'Halka açık Wi-Fi’da güvende kal', 'missions.public-wifi'],
        'malware' => ['truva-ati', 'Truva atı ve zararlı yazılımlar', 'missions.malware'],
        'backups' => ['yedekle', 'Fidye yazılımına karşı yedekle', 'missions.backups'],
        'data breach' => ['veri-sizintisi', 'Verilerin sızdı: şimdi ne olacak?', 'missions.data-breach'],
        'account recovery' => ['hesabin-ele-gecirildi', 'Hesabın ele geçirildi: kriz planı', 'missions.account-recovery'],
        'lost phone' => ['telefonun-kayboldu', 'Telefonun kayboldu ya da çalındı', 'missions.lost-phone'],
        'final siege' => ['son-sinav-kale-kusatmasi', 'Son sınav: Kale kuşatması', 'missions.final-siege'],
    ]);

    it('lets a guest play the first mission', function () {
        $this->get(route('missions.show', Mission::SecurityBasics))->assertOk();
    });

    it('sends a guest to registration for any later mission', function () {
        $response = $this->get(route('missions.show', Mission::StrongPassword));

        $response->assertRedirect(route('register'))
            ->assertSessionHas('status', fn (string $status) => str_contains($status, 'hesap oluştur'));
    });

    it('sends a learner back to the path when the mission is still locked', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics)->create();

        $response = $this->actingAs($learner)->get(route('missions.show', Mission::TwoFactor));

        $response->assertRedirect(route('missions.index'))
            ->assertSessionHas('status', fn (string $status) => str_contains($status, 'Kaleni katman katman savun'));
    });

    it('opens the next mission once the one before it is completed', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics, Mission::CastleDefense, Mission::StrongPassword)->create();

        $this->actingAs($learner)->get(route('missions.show', Mission::TwoFactor))->assertOk();
    });

    it('shows the chapter of the mission above its title', function () {
        $response = $this->get(route('missions.show', Mission::SecurityBasics));

        $response->assertOk()->assertSee('Görev 1 · Temeller');
    });

    it('offers the replay reward on a mission completed before', function () {
        $learner = User::factory()->completed(Mission::SecurityBasics)->create();

        $response = $this->actingAs($learner)->get(route('missions.show', Mission::SecurityBasics));

        $response->assertOk()->assertSee('Bu görevi daha önce tamamladın');
    });

    it('returns 404 for a mission that does not exist', function () {
        $this->get('/gorevler/olmayan-gorev')->assertNotFound();
    });
});

describe('exercise content', function () {
    beforeEach(function () {
        $this->actingAs(User::factory()->completed(...Mission::cases())->create());
    });

    it('renders the sorter with every scenario filed under an existing category', function () {
        $response = $this->get(route('missions.show', Mission::SecurityBasics));

        preg_match_all('/data-sorter-bin="([^"]+)"/', $response->getContent(), $bins);
        preg_match_all('/data-answer="([^"]+)"/', $response->getContent(), $answers);

        expect($bins[1])->toBe(['gizlilik', 'butunluk', 'erisilebilirlik'])
            ->and($answers[1])->toHaveCount(6)->each->toBeIn($bins[1]);
    });

    it('renders the link lab with exactly one owner part in every address', function () {
        $response = $this->get(route('missions.show', Mission::ReadingLinks));

        $addresses = array_slice(explode('data-url-address ', $response->getContent()), 1);
        $ownerPartsPerAddress = array_map(fn (string $address) => substr_count($address, 'data-url-part="domain"'), $addresses);

        expect($ownerPartsPerAddress)->toHaveCount(6)->each->toBe(1);
    });

    it('renders the phishing inbox with every practice email', function () {
        $response = $this->get(route('missions.show', Mission::PhishingEmail));

        expect(substr_count($response->getContent(), 'data-email '))->toBe(5);
    });

    it('renders both scam chats with exactly one safe reply in every answerable turn', function () {
        $response = $this->get(route('missions.show', Mission::ScamMessages));

        $turns = array_slice(explode('data-chat-turn ', $response->getContent()), 1);
        $answerableTurns = array_filter($turns, fn (string $turn) => str_contains($turn, 'data-chat-reply='));
        $safeRepliesPerTurn = array_map(fn (string $turn) => substr_count($turn, 'data-chat-reply="safe"'), $answerableTurns);

        expect(substr_count($response->getContent(), 'data-chat '))->toBe(2)
            ->and($safeRepliesPerTurn)->toHaveCount(4)->each->toBe(1);
    });

    it('renders the profile hunt with all seven leaks to find', function () {
        $response = $this->get(route('missions.show', Mission::Oversharing));

        expect(substr_count($response->getContent(), 'data-leak-label="'))->toBe(7);
    });

    it('renders the shop hunt with seven red flags and every purchase filed under an existing verdict', function () {
        $response = $this->get(route('missions.show', Mission::FakeShop));

        preg_match_all('/data-sorter-bin="([^"]+)"/', $response->getContent(), $verdicts);
        preg_match_all('/data-answer="([^"]+)"/', $response->getContent(), $answers);

        expect(substr_count($response->getContent(), 'data-leak-label="'))->toBe(7)
            ->and($verdicts[1])->toBe(['guvenli', 'supheli'])
            ->and($answers[1])->toHaveCount(6)->each->toBeIn($verdicts[1]);
    });

    it('renders the castle with five layers to inspect', function () {
        $response = $this->get(route('missions.show', Mission::CastleDefense));

        expect(substr_count($response->getContent(), 'data-castle-layer="'))->toBe(5)
            ->and(substr_count($response->getContent(), 'data-castle-part="'))->toBe(5)
            ->and(substr_count($response->getContent(), 'data-castle-template="'))->toBe(5);
    });

    it('renders the dragon trial as five emails that need four right answers', function () {
        $response = $this->get(route('missions.show', Mission::PhishingDragon));

        expect(substr_count($response->getContent(), 'data-email '))->toBe(5)
            ->and($response->getContent())->toContain('data-pass-score="4"');
    });

    it('renders the malware sorter with every case filed under an existing kind', function () {
        $response = $this->get(route('missions.show', Mission::Malware));

        preg_match_all('/data-sorter-bin="([^"]+)"/', $response->getContent(), $kinds);
        preg_match_all('/data-answer="([^"]+)"/', $response->getContent(), $answers);

        expect($kinds[1])->toBe(['virus', 'solucan', 'truva', 'casus'])
            ->and($answers[1])->toHaveCount(6)->each->toBeIn($kinds[1]);
    });

    it('renders the vault autofill demo with the real site and its lookalike', function () {
        $response = $this->get(route('missions.show', Mission::PasswordVault));

        $response->assertSee('data-autofill-site="mavibank.com.tr"', false)
            ->assertSee('data-autofill-site="mavibenk.com.tr"', false);
    });

    it('renders the final siege as twelve single-try questions with exactly one right answer each', function () {
        $response = $this->get(route('missions.show', Mission::FinalSiege));

        $questions = array_slice(explode('data-exam-question ', $response->getContent()), 1);
        $rightAnswersPerQuestion = array_map(fn (string $question) => substr_count($question, 'data-correct'), $questions);

        expect($response->getContent())->toContain('data-pass-score="10"')
            ->and($rightAnswersPerQuestion)->toHaveCount(12)->each->toBe(1);
    });

    it('renders the breach sorter with every leak filed under an existing action', function () {
        $response = $this->get(route('missions.show', Mission::DataBreach));

        preg_match_all('/data-sorter-bin="([^"]+)"/', $response->getContent(), $actions);
        preg_match_all('/data-answer="([^"]+)"/', $response->getContent(), $answers);

        expect($actions[1])->toBe(['parola', 'banka', 'tetikte'])
            ->and($answers[1])->toHaveCount(6)->each->toBeIn($actions[1]);
    });

    it('renders the crisis plan with stages counting up from one and two traps', function (Mission $mission, int $stepCount) {
        $content = $this->get(route('missions.show', $mission))->getContent();

        preg_match_all('/data-stage="(\d+)"/', $content, $stages);
        $distinctStages = array_map('intval', array_values(array_unique($stages[1])));
        sort($distinctStages);

        expect($stages[1])->toHaveCount($stepCount)
            ->and($distinctStages)->toBe(range(1, count($distinctStages)))
            ->and(substr_count($content, 'data-trap'))->toBe(2);
    })->with([
        'account recovery' => [Mission::AccountRecovery, 8],
        'lost phone' => [Mission::LostPhone, 5],
    ]);

    it('renders the wifi list with exactly one real network', function () {
        $response = $this->get(route('missions.show', Mission::PublicWifi));

        expect(substr_count($response->getContent(), 'data-network="real"'))->toBe(1)
            ->and(substr_count($response->getContent(), 'data-network="fake"'))->toBe(4);
    });
});
