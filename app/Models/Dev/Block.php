<?php


namespace App\Models\Dev;


use SleepingOwl\Admin\Traits\OrderableModel;

class Block extends \App\Models\Block
{
    use OrderableModel;

    protected $casts = [];

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
}