<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Interfaces\ITextVariablesContainer;
use App\Traits\MetaContainerTrait;
use Illuminate\Database\Eloquent\Model;

class City extends Model implements IDisplayable, IEditable, IMetaContainer, ITextVariablesContainer
{
    use MetaContainerTrait;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function variables()
    {
        return [
            '%city%'=>$this->name,
            '%city1%'=>$this->name1,
            '%city2%'=>$this->name2,
            '%city3%'=>$this->name3,
            '%city4%'=>$this->name4,
            '%city5%'=>$this->name5,
            '%city6%'=>'в ' . $this->name5,
        ];
    }

    /**
     * Implement IDisplayable interface
     *
     * @return string
     */
    public function getShowLink()
    {
        return "http://".$this->slug.".".$this->country->domain;
    }


    /**
     * Implement IEditable interface
     *
     * @return string
     */
    public function getEditLink()
    {
        return "/admin/".$this->getTable()."/".$this->id."/edit";
    }
}
