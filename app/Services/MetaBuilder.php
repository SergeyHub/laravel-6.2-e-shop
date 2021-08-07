<?php


namespace App\Services;


use App\Interfaces\IMetaContainer;
use App\Models\Meta;

class MetaBuilder
{
    private $sources = [];
    private $replacements = [];
    private $compiled = null;
    private static $_instance = null;
    public $cannonical = null;

    /**
     * Add Meta source to end of the queue
     *
     * @param mixed ...$sources
     * @return $this
     */
    public function using(...$sources)
    {
        foreach ($sources as $source) {
            if (is_array($source)) {
                array_push($this->sources, $source);
            }
            if ($source instanceof IMetaContainer) {
                array_push($this->sources, $source->metaValues());
            }
            if ($source instanceof Meta) {
                array_push($this->sources, [
                    'title' => $source->title,
                    'description' => $source->description,
                    'keywords' => $source->keywords,
                ]);
            }
            if (is_string($source)) {
                $this->using(\App\Models\Meta::where("key", $source)->first());
            }
        }
        return $this;
    }

    /**
     * Add replacement source toend of the queue
     *
     * @param mixed ...$replacements
     * @return $this
     */
    public function with(...$replacements)
    {
        foreach ($replacements as $replacement) {
            array_push($this->replacements, $replacement);
        }
        return $this;
    }

    /**
     * Get compiled Meta values array
     *
     * @param bool $object
     * @return array|object
     */

    public function compile($object = false)
    {
        if (!$this->compiled)
        {
            $data = [
                'title' => $this->_firstIsset('title'),
                'description' => $this->_firstIsset('description'),
                'keywords' => $this->_firstIsset('keywords')
            ];

            foreach ($this->replacements as $replacement)
            {
                $data['title'] = _rv($data['title'], $replacement);
                $data['description'] = _rv($data['description'], $replacement);
                $data['keywords'] = _rv($data['keywords'], $replacement);
            }


            $this->compiled = $data;
        }



        return $object ? (object)$this->compiled : $this->compiled;
    }

    /**
     * Clear compiled $meta array for recompile result. Using only if it's very important!
     *
     * @return $this
     */
    public function flushCompiled()
    {
        $this->compiled = null;
        return $this;
    }

    /**
     * Clear sources and replacements
     *
     * @return $this
     */
    public function clear()
    {
        $this->sources = [];
        $this->replacements = [];
        $this->compiled = null;
        return $this;
    }

    /**
     * Return global instance of MetaBuilder
     *
     * @return MetaBuilder|null
     */
    public static function instance()
    {
        return static::$_instance ?? static::$_instance = new MetaBuilder();
    }



    //--------------- Aliases for $this->compile() -------------------//

    /**
     * Get compiled Meta values array
     *
     * @param bool $object
     * @return array|object
     */
    public function resolve($object = false)
    {
        return $this->compile($object);
    }

    /**
     * Get compiled Meta values array
     *
     * @param bool $object
     * @return array|object
     */
    public function dispatch($object = false)
    {
        return $this->compile($object);
    }

    /**
     * Get compiled Meta values array
     *
     * @param bool $object
     * @return array|object
     */
    public function get($object = false)
    {
        return $this->compile($object);
    }

    /**
     * Get compiled Meta values array
     *
     * @param bool $object
     * @return array|object
     */
    public function result($object = false)
    {
        return $this->compile($object);
    }

    /**
     * Get compiled Meta values array
     *
     * @param bool $object
     * @return array|object
     */
    public function build($object = false)
    {
        return $this->compile($object);
    }

    //-------------- Getter for compiled params ---------------//

    function __get($property)
    {
        switch ($property)
        {
            case "title":
                return $this->get(true)->title;
                break;
            case "description":
                return $this->get(true)->description;
                break;
            case "keywords":
                return $this->get(true)->keywords;
                break;
            default:
                throw new \BadMethodCallException();
        }
    }

    //----------------------------------------//

    private function _firstIsset($key)
    {
        foreach ($this->sources as $source) {
            if (isset($source[$key]) && strlen($source[$key]) > 0) {
                return $source[$key];
            }
        }
        return cv("meta_".$key);
    }
}
