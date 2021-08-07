<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Filter extends Model implements IEditable, IDisplayable
{
    use OrderableModel;

    public function group()
    {
        return $this->belongsTo(FilterGroup::class,"filter_group_id");
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "product_filters");
    }

    public function getNameOrderedAttribute()
    {
        //return $this->name;
        $group = $this->group;
        return "{$group->name_ordered} : {$this->order}.{$this->name}";
    }

    /**
     * Implement IDisplayable interface
     *
     * @return string
     */
    public function getShowLink()
    {
        return "/catalog/".$this->alias;
    }

    /**
     * Implement IEditable interface
     *
     * @return string
     */
    public function getEditLink()
    {
        return "/admin/filters/".$this->id."/edit";
    }
}
