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
        $email = 'garble@example.com';
        $attributes = [
            'email' => $email,
        ];
        $user = User::whereEmail($email)->first();
        if (! $user instanceof User) {
            $user = factory(User::class)->create($attributes);
        }

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('login', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/');
        });
    }
}
