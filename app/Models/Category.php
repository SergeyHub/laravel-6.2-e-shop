<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Interfaces\ITextVariablesContainer;
use App\Traits\MetaContainerTrait;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Category extends Model implements IEditable, IDisplayable, IMetaContainer, ITextVariablesContainer
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
    /* public function products()
    {
        return $this->hasMany('App\Models\Product');
    } */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_category');
    }
    public function sets()
    {
        return $this->belongsToMany(Set::class, 'set_categories');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Category','parent_id');
    }
    public function childs()
    {
        return $this->hasMany('App\Models\Category','parent_id');
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
        return "/admin/categories/".$this->id."/edit";
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
