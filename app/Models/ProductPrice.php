<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'product_id', 'qty', 'price',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
