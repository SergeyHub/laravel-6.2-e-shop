<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correct extends Model
{
    public function items()
    {
        return $this->hasMany(CorrectItem::class);
    }
}
