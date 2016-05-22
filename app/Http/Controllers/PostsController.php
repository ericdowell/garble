<?php

namespace Garble\Http\Controllers;

use Garble\Post;

class PostsController extends TextController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = Post::class;
}
