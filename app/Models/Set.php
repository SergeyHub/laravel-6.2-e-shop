<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Traits\MetaContainerTrait;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Set extends Model implements IDisplayable, IEditable, IMetaContainer
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
        return $this->belongsToMany(Product::class, 'set_products');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'set_categories');
    }
    public function getPath()
    {
        $path = $this->slug;
        return $path;
    }
    public function getUrl()
    {
        return route('catalog.category',[$this->getPath()]).'/';
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

    /**
     * Implement IEditable interface
     *
     * @return string
     */
    public function getEditLink()
    {
        return "/admin/".$this->getTable()."/".$this->id."/edit";
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
