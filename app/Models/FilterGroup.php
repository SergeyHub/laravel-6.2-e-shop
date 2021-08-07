<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class FilterGroup extends Model
{
    use OrderableModel;

    public function filters()
    {
        return $this->hasMany(Filter::class)->where("status",1)->orderBy("order");
    }

    public function getNameOrderedAttribute()
    {
        return "{$this->order}. {$this->name}";
    }

    public function getEditLink()
    {
        return "/admin/filter_groups/".$this->id."/edit";
    }
}
