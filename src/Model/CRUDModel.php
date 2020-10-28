<?php
namespace ArnaudTriolet\Crudite\Model;

use Illuminate\Database\Eloquent\Model;
use ArnaudTriolet\Crudite\Model\CRUDIntel;

class CRUDModel extends Model
{
    use CRUDIntel;

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public function getThumbnail()
    {
        return null;
    }
    
    public function getTitle()
    {
        return null;
    }
    
    public function getContent()
    {
        return null;
    }
    
    public function getUrl()
    {
        return null;
    }
    
}
