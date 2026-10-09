<?php

use App\Enums\Mission;

it('lists the glossary terms alphabetically with links to the missions that teach them', function () {
    $response = $this->get(route('glossary'));

    $response->assertOk()
        ->assertSeeInOrder(['Alan adı', 'Fidye yazılımı', 'Şifreleme', 'Zararlı yazılım'])
        ->assertSee(route('missions.show', Mission::Encryption))
        ->assertSee('Görev 13: Şifrelemenin sırrını çöz');
});

it('is linked from the site navigation', function () {
    $this->get(route('missions.index'))
        ->assertOk()
        ->assertSee(route('glossary'));
});
