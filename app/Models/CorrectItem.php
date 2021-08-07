<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class CorrectItem extends Model
{
    use OrderableModel;

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
    public function correct()
    {
        return $this->belongsTo(Correct::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
