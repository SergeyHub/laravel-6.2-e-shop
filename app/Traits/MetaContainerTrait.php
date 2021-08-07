<?php


namespace App\Traits;


trait MetaContainerTrait
{
    /**
     * Import Meta from $data array using keys: 'slug','title','description','keywords','heading'
     *
     * @param $data
     * @return $this
     */
    public function metaImport($data)
    {
        if (isset($data['path']))
        {
            $this->path = $data['path'];
        }
        if (isset($data['title']))
        {
            $this->meta_title = $data['title'];
        }
        if (isset($data['description']))
        {
            $this->meta_description = $data['description'];
        }
        if (isset($data['keywords']))
        {
            $this->meta_tags = $data['keywords'];
        }
        if (isset($data['heading']))
        {
            $this->heading = $data['heading'];
        }

        return $this;
    }

    /**
     * Export Meta array|object with keys|properties: 'slug','title','description','keywords','heading'
     *
     * @param bool $object
     * @return array|object
     */
    public function metaExport($object = false)
    {
        $data = [
          'path'=>$this->path,
          'title'=>$this->meta_title,
          'description'=>$this->meta_description,
          'keywords'=>$this->meta_tags,
          'heading'=>$this->heading
        ];
        return $object ? (object) $data : $data;
    }

    /**
     * Get Meta values from object
     *
     * @param bool $object
     * @return array|object
     */
     public function metaValues($object = false)
     {
         $data = [
             'title'=>$this->meta_title,
             'description'=>$this->meta_description,
             'keywords'=>$this->meta_keywords ?? $this->meta_tags,
         ];
         return $object ? (object) $data : $data;
     }
}