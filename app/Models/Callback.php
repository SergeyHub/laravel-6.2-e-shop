<?php

namespace App\Models;

use App\Interfaces\IEditable;
use Illuminate\Database\Eloquent\Model;

class Callback extends Model implements IEditable
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'files' => 'array',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Implement IEditable interface
     *
     * @return string
     */
    public function getEditLink()
    {
        return "/admin/".$this->getTable()."/".$this->id."/edit";
    }
}
