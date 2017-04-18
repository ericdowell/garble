<?php

use Garble\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $garbleUser = User::where('name', 'gable')->get()->first();
        //New Install or being seeder being run for another time.
        if (empty($garbleUser) && empty(User::first())) {
            $userInfo = [
                'name' => 'Garble Admin',
                'username' => 'garble',
                'email' => 'garble@example.org',
                'password' => Hash::make(env('APP_KEY')),
            ];
            /** @var User $user */
            $user = factory(User::class)->create($userInfo)->save();

//            $user->assignRole('admin');
        }
    }
}
