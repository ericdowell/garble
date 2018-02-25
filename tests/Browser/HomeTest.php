<?php

namespace Garble\Tests\Browser;

use Laravel\Dusk\Browser;
use Garble\Tests\DuskTestCase;

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
