<?php
namespace ArnaudTriolet\Crudite\Model;

use Illuminate\Database\Eloquent\Model;

trait CRUDIntel
{
    public $fields = [
        // "key" => [
        //      "type" => "text", "textarea", "date", "datetime"
        //      "title" => "Exemple"
        // ],
    ];

    // List attributes to display in table
    public $fields_table = [

    ];
    

    public $forms = [
        "edit" =>  [
            "title" => [
                "title" => "Titre",
                "type" => "text"
            ],
            "content" => [
                "title" => "Titre",
                "type" => "image"
            ]
        ]
    ];

    public $actions_table = [
        // "edit" => [
        //     "route" => "home",
        //     "icon" => "pencil-quare",
        //     "title" => "Editer",
        //     "class" => "btn-primary"
        // ]
    ];

    public $extract_size = 80;
    static public $list_style = "cards"; // Or table
    static public $show_style = "article";


    abstract public function getThumbnail();
    abstract public function getTitle();
    abstract public function getContent();
    abstract public function getUrl();
    
    public function getExtract()
    {
        $content = strip_tags($this->getContent());
        if (strlen($content) >= $this->extract_size) {
            return substr($content, 0, $this->extract_size);
        }
        return $content;
    }

    public function getFieldData($attr, $data)
    {
        return isset($this->fields[$attr][$data]) ? $this->fields[$attr][$data] : null;
    }
    public function getFieldTitle($attr)
    {
        return !is_null($this->getFieldData($attr, "title")) ? $this->fields[$attr]["title"] : null;
    }
    
    public function getFieldDisplay($item, $attr)
    {
        $type = $this->getFieldData($attr, "type");
        switch ($type) {        
            case 'datetime':
                return date("d/m/Y H:i", strtotime($item->$attr));

            case 'image':
                return "<img src='" . $item->$attr . "' alt='" . $item->getTitle() . "'/>";

            case 'textarea':
                return (strlen($item->$attr) > $this->extract_size) ? substr($item->$attr, 0, $this->extract_size)."..." : $item->$attr;
                
            case 'relation':
                $method = $this->fields[$attr]["method"];
                $attribute = $this->fields[$attr]["attribute"];
                return $item->$method->$attribute;
            
            case 'morph':
                $method = $this->fields[$attr]["method"];
                $attribute = $this->fields[$attr]["child_method"];
                return $item->$method->{$attribute}();

            case 'text':
            default:
                return $item->$attr;
                break;
        }
    }
}
