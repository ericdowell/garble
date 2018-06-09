<?php

namespace Garble\Http\Controllers;

use Garble\Http\Requests\NoteRequest;
use Illuminate\Http\RedirectResponse;

class NoteController extends TextController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  NoteRequest $request
     *
     * @return RedirectResponse
     */
    public function store(NoteRequest $request): RedirectResponse
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NoteRequest $request
     * @param  string $slug
     *
     * @return RedirectResponse
     */
    public function update(NoteRequest $request, $slug): RedirectResponse
    {
        return $this->updateModel($request, $slug);
    }
}
