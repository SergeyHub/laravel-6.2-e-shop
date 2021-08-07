<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Block extends Model
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

    protected $casts = [
        'fields' => 'array',
        'values' => 'array'
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
