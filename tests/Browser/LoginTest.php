<?php

namespace Garble\Tests\Browser;

use Garble\User;
use Laravel\Dusk\Browser;
use Garble\Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginUser()
    {
        /** @var User $user */
        $user = factory(User::class)->create(['email' => 'garble@example.net', 'username' => 'garble-test']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('login', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/home')
                    ->clickLink($user->name)
                    ->clickLink('Logout');

            $browser->visit('/login')
                    ->type('login', $user->username)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/home')
                    ->clickLink($user->name)
                    ->clickLink('Logout');
        });
    }
}
