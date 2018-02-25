<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class HomeTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     * @throws \Exception
     * @throws \Throwable
     */
    public function testHomepageRendering()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Garble');
        });
    }
}
