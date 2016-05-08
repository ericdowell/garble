<?php

namespace Garble\Http\Controllers;

use Garble\Text;
use Garble\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

abstract class TextController extends Controller
{
    /**
     * @var string
     */
    protected $template;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $typeName;
    /**
     * @var \Illuminate\Routing\Route
     */
    private $route;
    /**
     * @var array
     */
    private $defaultData = [];

    /**
     * TextController constructor.
     */
    final public function __construct()
    {
        $this->route = app(Route::class);
        $this->template = $this->route()->getName();

        list($type) = explode('.', $this->template);
        $typeName = str_plural(ucfirst($type));

        $this->type = $type;
        $this->typeName = $typeName;
        $this->defaultData = compact('type', 'typeName');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->render(['all' => Text::allByType($this->type)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        ${$this->type} = Text::findBySlug($slug);

        return $this->render(compact($this->type));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                      $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
    }

    /**
     * @return Route
     */
    protected function route()
    {
        return $this->route;
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\Response
     */
    protected function render($data = [])
    {
        $html = view($this->template, $this->defaultData, $data)->render();

        return response($html);
    }
}
