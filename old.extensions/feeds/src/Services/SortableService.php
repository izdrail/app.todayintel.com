<?php

namespace SaturnPHP\Feeds\Services;

use SaturnPHP\Feeds\Repositories\Contracts\SortableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SortableService implements SortableInterface
{

    /**
     * @todo fix this by proper injecting something
     * @param Model $model
     * @param Request $request
     * @return mixed
     */
    public function sort($model, Request $request)
    {
        return $model->orderBy($request->get('sortWhat'), $request->get('sortHow'));
    }
}
