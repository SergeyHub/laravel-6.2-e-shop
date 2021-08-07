<?php

namespace App\Models;

use App\Interfaces\IEditable;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Review extends Model implements IEditable
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
    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
    public function shortDescription() {
        $res = '';
        if ($this->product) {
            $res .= '<div class="reviews__item__product">';
            $res .= '<a href="'.$this->product->getUrl().'">'.\strip_tags($this->product->name).'</a>';
            $res .= '</div>';
        }
        $res .= '<div class="add_description js-dots">';
        $descA = explode(' ',str_replace("\n",'<br>',strip_tags($this->message_full)));
        $res .= str_replace("\n",'<br>',strip_tags($this->message_full));
        $res .= '</div>';
        return $res;
        $resA = [];
        $dots = false;
        $len = 0;

        foreach ($descA as $word) {
            if ($len + strlen($word) > 200) {
                $dots = true;
                break;
            }
            $len += strlen($word);
            $resA[] = $word;
        }
        $res .= implode(' ',$resA);
        if($dots) {
            $res .= '<span class="js-dots">...</span>';
        }
        $res .= '</div>';
        return $res;
    }
    public function addDescription() {

        $descA = explode(' ',str_replace("\n",'<br>',strip_tags($this->message_full)));
        $resA = [];
        $dots = false;
        $len = 0;

        foreach ($descA as $word) {
            if ($len + strlen($word) > 200) {
                $dots = true;
                break;
            }
            $len += strlen($word);
            $resA[] = $word;
        }
        if ($dots) {
            return str_replace("\n",'<br>',strip_tags($this->message_full));
        }
        return '';
        $res = implode(' ',$resA);

        $res = str_replace(["\n",$res],['<br>',''],strip_tags($this->message_full));
        return $res;
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
