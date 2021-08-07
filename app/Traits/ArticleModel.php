<?php
namespace App\Traits;


trait ArticleModel
{

    public function variables()
    {
        return [
            "%title%"=>strip_tags($this->title),
            "%description%"=>strip_tags($this->description)
        ];
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

    /**
     * Implement IDisplayable interface
     *
     * @return string
     */
    public function getShowLink()
    {
        return $this->getUrl();
    }

    //--------------------- DATA ACCESSING FOR META EDITOR ----------------------//

    function getPathAttribute()
    {
        return $this->slug;
    }

    function setPathAttribute($val)
    {
        $this->slug = $val;
    }

    function getHeadingAttribute()
    {
        return $this->title;
    }

    function setHeadingAttribute($val)
    {
        $this->title = $val;
    }
}
