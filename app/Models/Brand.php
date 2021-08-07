<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Interfaces\ITextVariablesContainer;
use App\Traits\MetaContainerTrait;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Brand extends Model implements IEditable, IDisplayable, IMetaContainer, ITextVariablesContainer
{
    use OrderableModel, MetaContainerTrait;

    /**
     * @param $query
     * @param int $position
     *
     * @return mixed
     */
    public function scopeFindByPosition($query, $position)
    {
        return $query->where($this->getOrderField(), $position);
    }
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_brands');
    }
    public function getPath($parent)
    {
        $path = $this->slug;
        if ($parent) {
            $path = $parent->getPath() . '/' . $path;
        }
        return $path;
    }
    public function getUrl($parent = null)
    {
        return route('catalog.category',[$this->slug]).'/';
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
        return $this->getUrl();
    }

    public function variables()
    {
        return [
            "%title%"=>strip_tags($this->name),
            "%description%"=>\mb_substr(strip_tags($this->long_description), 0, 255)
        ];
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
        return $this->name;
    }

    function setHeadingAttribute($val)
    {
        $this->name = $val;
    }
}
