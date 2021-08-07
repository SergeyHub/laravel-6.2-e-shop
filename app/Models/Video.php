<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Video extends Model
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
    public function getImage() 
    {
        return $this->image?$this->image:'//img.youtube.com/vi/'.$this->remote_id.'/maxresdefault.jpg'; // /images/uploads/9434a0fdbca39286b28e1871a61e67b2.jpg
    }
}
