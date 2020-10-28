<?php

namespace ArnaudTriolet\Crudite\Builder;

trait Fields
{
    static function getEditField($name, $config, $item)
    {
        // dd($item, $config, $name);
        $data = [
            "config" => $config,
            "name" => $name,
            "settings" => $item->fields[$name],
            "item" => $item
        ];

        switch ($config["type"]) {
            case 'text':
                return view("crudite::form/fields/text", $data);
            
            case 'number':
                return view("crudite::form/fields/number", $data);

            case 'datetime':
                return view("crudite::form/fields/datetime", $data);
            
            case 'relation':
                return view("crudite::form/fields/relation", $data);

            case 'textarea':
                return view("crudite::form/fields/textarea", $data);
            
            case 'wysiwyg':
                return view("crudite::form/fields/wysiwyg", $data);

            case 'image':
                return view("crudite::form/fields/image", $data);

            default:
                return "todo";
        }
    }
}
