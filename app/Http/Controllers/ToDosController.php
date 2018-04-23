<?php

namespace Garble\Http\Controllers;

use Garble\ToDo;
use Illuminate\Http\RedirectResponse;
use Garble\Http\Requests\ToDosRequest;

class ToDosController extends TextController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $modelClass = ToDo::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  ToDosRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ToDosRequest $request): RedirectResponse
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ToDosRequest $request
     * @param  string $slug
     *
     * @return RedirectResponse
     */
    public function update(ToDosRequest $request, $slug): RedirectResponse
    {
        return $this->updateModel($request, $slug);
    }
}
