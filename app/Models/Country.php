<?php

namespace App\Models;

use App\Interfaces\ITextVariablesContainer;
use Illuminate\Database\Eloquent\Model;

class Country extends Model implements ITextVariablesContainer
{
    public function corrects()
    {
        return $this->hasMany(CorrectItem::class);
    }

    //
    public function variables()
    {
        return [
            '%country%'=>$this->name,
            '%country_domain%'=>$this->domain,
            '%currency%'=>$this->currency,
        ];
    }
}
