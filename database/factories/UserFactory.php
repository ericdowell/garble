<?php

use Garble\Note;
use Garble\Post;
use Garble\ToDo;
use Garble\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    static $password, $username;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $username ?: $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Note::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'body' => $faker->paragraphs(),
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'title' => $faker->sentence,
        'body' => $faker->paragraph(),
    ];
});

$factory->define(ToDo::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'title' => $faker->sentence,
        'completed' => $faker->boolean(),
    ];
});
