<?php

namespace Garble\Http\Controllers;

use Garble\ToDo;

class ToDosController extends TextController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = ToDo::class;
}
