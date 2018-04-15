<?php

namespace Garble\Http\Controllers;

use Garble\Text;
use Garble\ToDo;
use Garble\Http\Requests\ToDosRequest;

class ToDosController extends MorphModelController
{
    /**
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model = ToDo::class;
    /**
     * @var string
     */
    protected $morphModel = Text::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Garble\Http\Requests\ToDosRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ToDosRequest $request)
    {
        return parent::storeModel($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Garble\Http\Requests\ToDosRequest $request
     * @param  string                             $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ToDosRequest $request, $slug)
    {
        return parent::updateModel($request, $slug);
    }
}
