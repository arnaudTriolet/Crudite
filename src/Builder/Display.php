<?php

namespace ArnaudTriolet\Crudite\Builder;

use Illuminate\Support\Facades\Request;

trait Display
{
    static function form($model, $formName, $item = null)
    {
        $model = new $model();
        $config = $model->forms[$formName];
        $currentRouteName = Request::route()->getName();
        return view("crudite::form/form", [
            "item" => $item,
            "config" => $config,
            "model" => $model,
            "currentRouteName" => $currentRouteName,
            "form_name" => $formName
        ]);
    }

    static function table($model, $data)
    {
        return view("crudite::list/table", [
            "collection" => $data,
            "model" => new $model
        ]);
    }

    static function list($model, $data)
    {
        return view("crudite::list/" . $model::$list_style, [
            "collection" => $data
        ]);
    }

    static function show($model, $item)
    {
        return view("crudite::show/" . $model::$show_style, [
            "item" => $item
        ]);
    }
}
