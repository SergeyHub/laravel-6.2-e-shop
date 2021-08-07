<?php

namespace App\Models;

use App\Interfaces\IDisplayable;
use App\Interfaces\IEditable;
use App\Interfaces\IMetaContainer;
use App\Interfaces\ITextVariablesContainer;
use App\Traits\MetaContainerTrait;
use App\Traits\ProductPricesTrait;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Product extends Model implements IEditable, IDisplayable, IMetaContainer, ITextVariablesContainer
{
    use OrderableModel, MetaContainerTrait, ProductPricesTrait;

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
    protected $casts = [
        'images' => 'array',
        'images_visibility' => 'array',
        'complect' => 'array',
        'feature' => 'array',
        'specification' => 'array',
    ];



    public function filters()
    {
        return $this->belongsToMany('App\Models\Filter', 'product_filters')->orderBy("order")->where("status",1);
    }

    /**
     * Один ко многим с категорией
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_category');
    }
    public function brands()
    {
        return $this->belongsToMany('App\Models\Brand', 'product_brands');
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function similar()
    {
        return $this->belongsToMany('App\Models\Product', 'product_similars','product_id','reference_id');
    }
    public function recommends()
    {
        return $this->belongsToMany('App\Models\Product', 'product_recomends','product_id','reference_id');
    }
    public function buywith()
    {
        return $this->belongsToMany('App\Models\Product', 'product_withs','product_id','reference_id');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review')->where('status',1);
    }
    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function getPath()
    {

        //$path = $this->categories->count() ? ($this->categories->first()->getPath().'/') : '';

        $path = $this->slug;
        return $path;
    }
    public function getUrl()
    {
        $url = route('catalog.show',[$this->getPath()]).'/';
        return $url;
    }
    public function getParametr($field) {
        $res = '';
        $lines = explode("\n",$this->specification);
        foreach ($lines as $key => $line) {
            if (strpos($line,$field) !== false) {
                $arr = explode('|',$line);
                if (isset($arr[1])) {
                    $res = trim($arr[1]);
                }
            }
        }
        return $res;
    }
    public function getImage($num = 0)
    {
        $images = $this->getVisibleImagesAttribute();
        return $images[$num] ?? '';
    }
    public function getAlt($num = 0)
    {
        $altA = explode("\n",str_replace("\r",'',$this->image_alts));
        return isset($altA[$num]) ? $altA[$num]: '';
    }


    public function shortDescription() {
        $descA = explode(' ',str_replace("\n",'<br>',strip_tags($this->short_description)));
        $resA = [];
        $dots = false;
        $len = 0;

        foreach ($descA as $word) {
            if ($len + strlen($word) > 80) {
                $dots = true;
                break;
            }
            $len += strlen($word);
            $resA[] = $word;
        }
        $res = implode(' ',$resA);
        if($dots) {
            $res .= '<span class="js-dots">...</span>';
        }
        return $res;
    }
    public function addDescription() {
        $descA = explode(' ',str_replace("\n",'<br>',strip_tags($this->short_description)));
        $resA = [];
        $dots = false;
        $len = 0;

        foreach ($descA as $word) {
            if ($len + strlen($word) > 80) {
                $dots = true;
                break;
            }
            $len += strlen($word);
            $resA[] = $word;
        }
        $res = implode(' ',$resA);

        $res = str_replace("\n",'<br>',str_replace($res,'',$this->short_description));
        return $res;
    }
    public function discount()
    {
        if (!$old = $this->getPrice(0)) {
            return null;
        }
        $new = $this->getPrice();
        $discount = -1 * round(100 - $new * 100 / $old,0);
        return $discount.'%';

    }

    /**
     * Returns images array using image visible flags
     *
     * @return array
     */

    public function getVisibleImagesAttribute()
    {
        if (is_null($this->images) || !is_array($this->images) || count($this->images) == 0)
        {
            return ['/images/project/no-photo.jpg'];
        }
        $res = array_values(array_diff($this->images,$this->images_visibility ?? []));
        return count($res) ? $res : ['/images/project/no-photo.jpg'];
    }

    /**
     * Implement IDisplayable interface
     *
     * @return string
     */
    public function getShowLink()
    {
        return $this->getUrl();
    }


    /**
     * Implement IEditable interface
     *
     * @return string
     */
    public function getEditLink()
    {
        return "/admin/products/".$this->id."/edit";
    }

    public function variables()
    {
        return [
            '%product%' => $this->name,
            '%name%' => strip_tags($this->name),
            '%name1%' => strip_tags($this->name1),
            '%name2%' => strip_tags($this->name2),
            '%name3%' => strip_tags($this->name3),
            '%name4%' => strip_tags($this->name4),
            '%name5%' => strip_tags($this->name5),
            '%name_small%' => mb_lcfirst(strip_tags($this->name)),
            '%name1_small%' => mb_lcfirst(strip_tags($this->name1)),
            '%name2_small%' => mb_lcfirst(strip_tags($this->name2)),
            '%name3_small%' => mb_lcfirst(strip_tags($this->name3)),
            '%name4_small%' => mb_lcfirst(strip_tags($this->name4)),
            '%name5_small%' => mb_lcfirst(strip_tags($this->name5)),
            '%category%' => strip_tags($this->categories->first() ? $this->categories->first()->name : ''),
            '%brand%' => strip_tags($this->brands->first() ? $this->brands->first()->name : ''),
            //'%brand%' => $this->brand ? strip_tags($this->brand->name) : '',
            //'%category%' => $this->category ? $this->category->name : null,
            '%description%' => \mb_substr(strip_tags($this->short_description), 0, 255),
            '%price%' => $this->getPrice(),
            '%discount_percent%' => $this->discount_percent,
            '%discount_value%' => $this->discount
        ];
    }

    public function setHideAttribute($value)
    {

    }

    public function getHideAttribute()
    {
        return !$this->status;
    }

    //--------------------- DATA ACCESSING FOR META EDITOR ----------------------//
    function getPathAttribute()
    {
        return $this->getPath();
    }

    function setPathAttribute($val)
    {
        $slugs = explode("/",$val);
        $this->slug = array_last($slugs);
    }

    function getHeadingAttribute()
    {
        return $this->name;
    }

    function setHeadingAttribute($val)
    {

    }
}
