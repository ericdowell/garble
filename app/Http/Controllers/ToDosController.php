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
    protected $model = ToDo::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  ToDosRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ToDosRequest $request): RedirectResponse
    {
        return parent::storeModel($request);
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
        return parent::updateModel($request, $slug);
    }
}
