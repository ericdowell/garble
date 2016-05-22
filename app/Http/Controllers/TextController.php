<?php

namespace Garble\Http\Controllers;

use Auth;
use Garble\Text;
use Garble\Http\Requests;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

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
        if( php_sapi_name() != 'cli' ) {
            $this->setupModel();
            $this->route = app(Route::class);
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
        $options = ['route' => 'note.'.$this->formAction];
        $body = request()->old('body');

        return $this->render(compact('options', 'body'));
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
        $slug = Str::slug($request->input('slug'));
        $userId = Auth::user()->id;
        try {
            Text::findBySlug($slug);
            $error = new MessageBag([
                'slug' => 'That slug is already in use.',
            ]);

            return redirect()->back()->withErrors($error)->withInputs();
        }
        catch (ModelNotFoundException  $e) {
            $modelAttributes = [
                'body'    => $request->input('body'),
                'user_id' => $userId,
            ];
            $model = $this->modelInstance->create($modelAttributes);

            $model->save();

            $attributes = [
                'slug'      => $slug,
                'text_type' => $this->type,
                'text_id'   => $model->id,
                'user_id'   => $userId,
            ];
            $text = Text::create($attributes);

            $text->save();
        }

        return redirect()->route($this->type . '.index');
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
        $options = ['route' => ['note.'.$this->formAction, $instance->slug], 'method' => 'put'];
        $body = request()->old('body') ?: $instance->text->body;

        return $this->render(compact('instance', 'options', 'body'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $text = Text::findBySlug($slug);
        $userId = Auth::user()->id;

        $attributes = [
            'body'    => $request->input('body'),
            'user_id' => $userId,
        ];
        /** @var Model $model */
        $model = $text->text;

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
//        $userId = Auth::user()->id;

        /** @var Model $model */
        $model = $text->text;

        $model->destroy($model->id);
        $text->destroy($text->slug);

        return redirect()->route($this->type.'.index');
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
        if (!class_exists($modelException->getModel())) {
            throw $modelException;
        }

        return $this;
    }
}
