<?php

declare(strict_types=1);

namespace Garble\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:user {--M|model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a new user account.';

    /**
     * Get the Laravel application instance.
     *
     * @return string
     * @throws \Exception
     */
    public function getUserModelClassName(): string
    {
        /** @var \Illuminate\Foundation\Application $laravel */
        $laravel = $this->laravel;
        $fallback = $laravel->getNamespace().'\\User';

        $userModel = $this->option('model') ?? config('auth.providers.users.model', $fallback);
        if (! class_exists($userModel)) {
            throw new Exception($userModel.' does not exist.');
        }

        return $userModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle(): int
    {
        $attributes = [];
        $userModel = $this->getUserModelClassName();
        $attributes['name'] = $this->ask('Enter name');

        $this->askForEmail($attributes);

        $inputUsername = $this->confirm('Do you want to set a username?');
        if ($inputUsername) {
            $attributes['username'] = $this->ask('Enter in username');
        }

        $this->askForPassword($attributes);

        $created = forward_static_call([$userModel, 'create'], $attributes);
        if ($created) {
            $outputSafe = array_except($attributes, ['password']);
            $this->info('User successfully created!');
            $this->table(array_keys($outputSafe), [array_values($outputSafe)]);

            return 0;
        }
        $this->info('Sorry, user was NOT created. Please try again.');

        return 1;
    }

    /**
     * @param array $attributes
     */
    protected function askForEmail(array &$attributes)
    {
        $email = $this->ask('Enter in an email');
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
        $password = $this->secret('Enter password');
        $confirm = $this->secret('Confirm password');
        if ($password === $confirm) {
            $attributes['password'] = Hash::make($password);

            return;
        }
        $this->info('The password and confirmation password do NOT match, please try again.');

        $this->askForPassword($attributes);
    }
}
