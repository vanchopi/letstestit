<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Test extends Model
{
	use Searchable;
    
    public function searchableAs()
    {
        return 'tests_index';
    }

    public function getScoutKey()
    {
        return $this->title;
    }

    public function getScoutKeyName()
    {
        return 'title';
    }

    /*public function toSearchableArray()
    {
        //$array = $this->toArray();
        //$array = $this->transform($array);
        //return $array;

        $array = $this->toArray();
        $array['opa'] = 'opa';       

        return $array;
    }*/
}
