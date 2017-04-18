<?php

namespace Garble\Providers;

use Garble\Note;
use Garble\Post;
use Garble\ToDo;
use Laravel\Dusk\DuskServiceProvider;
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
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
