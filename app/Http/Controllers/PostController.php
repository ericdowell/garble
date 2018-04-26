<?php

namespace Garble\Http\Controllers;

use Garble\Post;
use Illuminate\Http\RedirectResponse;
use Garble\Http\Requests\PostRequest;

class PostController extends TextController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $modelClass = Post::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostRequest $request
     *
     * @return RedirectResponse
     */
    public function store(PostRequest $request): RedirectResponse
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostRequest $request
     * @param  string $slug
     *
     * @return RedirectResponse
     */
    public function update(PostRequest $request, $slug): RedirectResponse
    {
        return $this->updateModel($request, $slug);
    }
}
