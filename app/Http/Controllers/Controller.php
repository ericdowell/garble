<?php

namespace Garble\Http\Controllers;

use Route;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * @param $model
     */
    protected function authorizedAction($model)
    {
        $fullAction = __NAMESPACE__.'\\'.Route::currentRouteAction();

        $this->authorize($fullAction, [$model]);
    }
}
