<?php

namespace Garble\Http\Controllers;

use Route;
use Garble\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class TextPublicController extends Controller
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
    protected $route;
    /**
     * @var array
     */
    protected $mergeData = [];
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
    protected $publicActions = [
        'index',
        'show',
    ];
    /**
     * @var string
     */
    protected $formAction;

    /**
     * TextPublicController constructor.
     */
    public function __construct()
    {
        $this->setupModel()
            ->setupDefaults();
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
        $html = view($this->template, $data, $this->mergeData)->render();

        return response($html);
    }

    /**
     * @param mixed $items
     *
     * @return $this
     */
    protected function pushToDefaults(array $items)
    {
        $this->mergeData = array_merge($this->mergeData, $items);

        return $this;
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

    /**
     * @return $this
     */
    protected function setupDefaults()
    {
        $this->route = Route::current();
        if (method_exists($this->route, 'getName') && ! empty($this->route->getName())) {
            $this->template = $this->route()->getName();

            $this->setTypeAndFormAction()
                ->setTypeName()
                ->setModelInstance();
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setTypeAndFormAction()
    {
        list($type, $action) = explode('.', $this->template);

        if (array_key_exists($action, $this->actionMap)) {
            $action = $this->actionMap[$action];
        }
        $this->type = $type;
        $this->formAction = $action;
        $btnMessage = sprintf('%s %s', ucfirst($this->formAction), ucfirst($this->type));

        $data = compact('type', 'btnMessage', 'action');

        return $this->pushToDefaults($data);
    }

    /**
     * @return $this
     */
    protected function setTypeName()
    {
        $this->typeName = $typeName = str_plural(ucfirst($this->type));

        return $this->pushToDefaults(compact('typeName'));
    }

    /**
     * @return $this
     */
    protected function setModelInstance()
    {
        $this->modelInstance = $instance = new $this->model();

        return $this->pushToDefaults(compact('instance'));
    }
}
