<?php

namespace Garble\Http\Controllers;

use Garble\Post;
use Illuminate\Http\RedirectResponse;
use Garble\Http\Requests\PostsRequest;

class PostsController extends TextController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostsRequest $request
     *
     * @return RedirectResponse
     */
    public function store(PostsRequest $request): RedirectResponse
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostsRequest $request
     * @param  string $slug
     *
     * @return RedirectResponse
     */
    public function update(PostsRequest $request, $slug): RedirectResponse
    {
        return $this->updateModel($request, $slug);
    }
}
