<?php

namespace Garble\Http\Controllers;

use Garble\Note;
use Illuminate\Http\RedirectResponse;
use Garble\Http\Requests\NotesRequest;

class NotesController extends TextController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  NotesRequest $request
     *
     * @return RedirectResponse
     */
    public function store(NotesRequest $request): RedirectResponse
    {
        return $this->storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NotesRequest $request
     * @param  string $slug
     *
     * @return RedirectResponse
     */
    public function update(NotesRequest $request, $slug): RedirectResponse
    {
        return $this->updateModel($request, $slug);
    }
}
