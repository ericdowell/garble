<?php

namespace Garble\Console\Commands;

use Garble\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user account.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $attributes = [];
        $attributes['name'] = $this->ask('Enter name:');

        $this->askForEmail($attributes);

        $inputUsername = $this->confirm('Do you want to set a username?');
        if ($inputUsername) {
            $attributes['username'] = $this->ask('Enter in username:');
        }

        $this->askForPassword($attributes);

        $created = User::create($attributes);
        if ($created) {
            $outputSafe = array_except($attributes, ['password']);
            $this->info('User created!');
            $this->table(array_keys($outputSafe), [array_values($outputSafe)]);

            return 0;
        }
        $this->info('Sorry, user was not created. Please try again.');

        return 1;
    }

    /**
     * @param array $attributes
     */
    protected function askForEmail(array &$attributes)
    {
        $email = $this->ask('Enter in an email:');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $attributes['email'] = $email;

            return;
        }
        $this->info("Email '{$email}' is not valid, please try again.'");

        $this->askForEmail($attributes);
    }

    /**
     * @param array $attributes
     */
    protected function askForPassword(array &$attributes)
    {
        $password = $this->secret('Enter password:');
        $confirm = $this->secret('Confirm password:');
        if ($password === $confirm) {
            $attributes['password'] = Hash::make($password);

            return;
        }
        $this->info('The password and confirmation password don\'t match, please try again.');

        $this->askForPassword($attributes);
    }
}
