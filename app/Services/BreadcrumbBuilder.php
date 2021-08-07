<?php

namespace App\Services;

class BreadcrumbBuilder
{
    private $items = [];
    private static $_instance;

    /**
     * Set root crumb
     *
     * @param string $name
     * @return $this
     */
    public function root($name = "Главная")
    {
        $this->to($name, "/");
        return $this;
    }

    /**
     * Set intermediate/last crumb
     *
     * @param $name
     * @param null $href
     * @return $this
     */
    public function to($name, $href = null)
    {
        array_push($this->items,['name'=>$name, 'href'=>$href]);
        return $this;
    }

    /**
     * Get complided breadcrumbs
     *
     * @return array
     */
    public function get()
    {
        return $this->items;
    }

    /**
     * Return length of breadcrumbs
     *
     * @return int
     */
    public function length()
    {
        return count($this->items);
    }


    /**
     * Clear sources and replacements
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * Return global instance of MetaBuilder
     *
     * @return BreadcrumbBuilder
     */
    public static function instance()
    {
        return static::$_instance ?? static::$_instance = new BreadcrumbBuilder();
    }

    function __get($property)
    {
        switch ($property)
        {
            case "length":
                return $this->length();
                break;
            default:
                throw new \BadMethodCallException();
        }
    }

}