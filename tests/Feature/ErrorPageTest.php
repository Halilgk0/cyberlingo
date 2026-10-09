<?php

it('shows a themed page with a way back to the path for an address that does not exist', function () {
    $response = $this->get('/olmayan-bir-sayfa');

    $response->assertNotFound()
        ->assertSee('Bu kapı duvar çıktı')
        ->assertSee(route('missions.index'));
});

it('renders the server error page without the database or a logged-in learner', function () {
    $this->view('errors.500')
        ->assertSee('Kalede bir şey ters gitti')
        ->assertSee('Hata 500');
});
