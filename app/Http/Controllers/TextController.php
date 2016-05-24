<?php

namespace Garble\Http\Controllers;

use Route;
use Garble\Text;
use Garble\Http\Requests\TextsRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * Name of the affected Eloquent model.
     *
     * @var string
     */
    protected $model;
    /**
     * @var Model
     */
    protected $modelInstance;
    /**
     * @var array
     */
    protected $actionMap = [
        'create' => 'store',
        'edit'   => 'update',
    ];
    /**
     * @var string
     */
    protected $formAction;

    /**
     * TextController constructor.
     */
    final public function __construct()
    {
        $this->setupModel();
        $this->route = Route::current();
        if (method_exists($this->route, 'getName') && ! empty($this->route->getName())) {
            $this->template = $this->route()->getName();

            list($type, $action) = explode('.', $this->template);
            $typeName = str_plural(ucfirst($type));
            if (array_key_exists($action, $this->actionMap)) {
                $action = $this->actionMap[$action];
            }
            $this->formAction = $action;
            $btnMessage = sprintf('%s %s', ucfirst($action), ucfirst($type));

            $model = $this->model;
            $instance = new $model();
            $this->modelInstance = $instance;

            $this->type = $type;
            $this->typeName = $typeName;

            $this->defaultData = compact('type', 'action', 'typeName', 'btnMessage', 'instance');
        }
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
        $options = ['route' => sprintf('%s.%s', $this->type, $this->formAction)];

        return $this->render(compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Garble\Http\Requests\TextsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeModel(TextsRequest $request)
    {
        $modelAttributes = [];
        foreach ($this->modelInstance->getFillable() as $key) {
            $input = $request->input($key);
            if (! empty($input)) {
                $modelAttributes[$key] = $input;
            }
        }
        $model = $this->modelInstance->create($modelAttributes);

        $model->save();

        $attributes = [
            'slug'      => $request->input('slug'),
            'text_type' => $this->type,
            'text_id'   => $model->id,
            'user_id'   => $request->input('user_id'),
        ];
        $text = Text::create($attributes);

        $text->save();

        return redirect()->route($this->type.'.index');
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
        $instance = Text::findBySlug($slug);
        $options = [
            'route'  => [sprintf('%s.%s', $this->type, $this->formAction), $instance->slug],
            'method' => 'put',
        ];

        return $this->render(compact('instance', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Garble\Http\Requests\TextsRequest $request
     * @param  string                             $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function updateModel(TextsRequest $request, $slug)
    {
        $text = Text::findBySlug($slug);
        $attributes = [];

        if ($slug != $text->slug) {
            $text->update(['slug' => $slug]);
        }

        /** @var Model $model */
        $model = $text->text;
        //Loop over fillable fields
        foreach ($model->getFillable() as $key) {
            $input = $request->input($key);
            if (! empty($input)) {
                $attributes[$key] = $input;
            }
        }

        $model->update($attributes);

        return redirect()->route($this->type.'.index');
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
        $text = Text::findBySlug($slug);
        /** @var Model $model */
        $model = $text->text;

        $model->destroy($model->id);
        $text->destroy($text->slug);

        return redirect()->route($this->type.'.index');
    }

    /**
     * @return \Illuminate\Routing\Route
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
        $html = view($this->template, $data, $this->defaultData)->render();

        return response($html);
    }

    /**
     * @throws ModelNotFoundException
     *
     * @return $this
     */
    protected function setupModel()
    {
        /** @var ModelNotFoundException $modelException */
        $modelException = with(new ModelNotFoundException())->setModel($this->model);
        if (! class_exists($modelException->getModel())) {
            throw $modelException;
        }

        return $this;
    }
}
