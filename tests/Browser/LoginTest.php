<?php

namespace Tests\Browser;

use Garble\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Exception
     * @throws \Throwable
     */
    public function testLoginUser()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => 'garble@example.net',
            'username' => 'garble-test',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->resize(1280, 720);

            $browser->visitRoute('login')
                    ->type('login', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertRouteIs('home.index')
                    ->clickLink($user->name)
                    ->clickLink('Logout');

            $browser->visitRoute('login')
                    ->type('login', $user->username)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertRouteIs('home.index')
                    ->clickLink($user->name)
                    ->clickLink('Logout');
        });
    }
}
