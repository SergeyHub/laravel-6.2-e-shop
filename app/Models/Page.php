<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Traits\MetaContainerTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model  implements IDisplayable, IEditable, IMetaContainer
{
    use MetaContainerTrait;

    protected $casts = [
        'data' => 'array'
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
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

    /**
     * Implement IDisplayable interface
     *
     * @return string
     */
    public function getShowLink()
    {
        return "/".$this->slug;
    }

    //--------------------- DATA ACCESSING FOR META EDITOR ----------------------//
    function getPathAttribute()
    {
        return $this->slug;
    }

    function setPathAttribute($val)
    {
        $this->slug = $val;
    }

    function getHeadingAttribute()
    {
        return $this->title;
    }

    function setHeadingAttribute($val)
    {
        $this->title = $val;
    }
}
