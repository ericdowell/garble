<?php

namespace Garble\Http\Controllers;

use Garble\Note;

class NotesController extends TextController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = Note::class;
}
