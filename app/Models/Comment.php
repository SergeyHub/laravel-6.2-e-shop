<?php

namespace App\Models;

use App\Interfaces\IEditable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model implements IEditable
{
    public function blog()
    {
        return $this->belongsTo(Blog::class);
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
