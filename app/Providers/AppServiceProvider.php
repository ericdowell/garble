<?php

namespace Garble\Providers;

use Garble\Note;
use Garble\Post;
use Garble\ToDo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (is_numeric(env('DB_DEFAULT_STRING_LENGTH'))) {
            Schema::defaultStringLength(env('DB_DEFAULT_STRING_LENGTH'));
        }
        Relation::morphMap([
            'note' => Note::class,
            'post' => Post::class,
            'todo' => ToDo::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
