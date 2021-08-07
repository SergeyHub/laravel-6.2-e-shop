<?php

namespace App\Models;

use App\Interfaces\IEditable;
use App\Mail\Answer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Question extends Model implements IEditable
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sendAnswer()
    {
        if ($this->answer && $this->status && !$this->mail_hash) {
            $this->mail_hash = md5($this->id.$this->answer.time());
            $this->save();
            Mail::to($this->email)->send(new Answer($this));
            return true;
        }
        return false;
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
