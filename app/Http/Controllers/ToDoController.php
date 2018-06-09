<?php

namespace Garble\Http\Controllers;

use Garble\Http\Requests\ToDoRequest;
use Illuminate\Http\RedirectResponse;

class ToDoController extends TextController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  ToDoRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ToDoRequest $request): RedirectResponse
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ToDoRequest $request
     * @param  string $slug
     *
     * @return RedirectResponse
     */
    public function update(ToDoRequest $request, $slug): RedirectResponse
    {
        return $this->updateModel($request, $slug);
    }
}
