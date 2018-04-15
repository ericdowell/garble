<?php

namespace Garble\Http\Controllers;

use Garble\Note;
use Garble\Text;
use Illuminate\Http\RedirectResponse;
use Garble\Http\Requests\NotesRequest;

class NotesController extends MorphModelController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * @var string
     */
    protected $morphModel = Text::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  NotesRequest $request
     *
     * @return RedirectResponse
     */
    public function store(NotesRequest $request): RedirectResponse
    {
        return parent::storeModel($request);
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
        return parent::updateModel($request, $slug);
    }
}
