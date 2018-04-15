<?php

namespace Garble\Http\Controllers;

use Garble\Post;
use Garble\Text;
use Illuminate\Http\RedirectResponse;
use Garble\Http\Requests\PostsRequest;

class PostsController extends MorphModelController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * @var string
     */
    protected $morphModel = Text::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostsRequest $request
     *
     * @return RedirectResponse
     */
    public function store(PostsRequest $request): RedirectResponse
    {
        return parent::storeModel($request);
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
        return parent::updateModel($request, $slug);
    }
}
