<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'date'
    ];
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
