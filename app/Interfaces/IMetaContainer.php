<?php


namespace App\Interfaces;


use App\Traits\MetaContainerTrait;

interface IMetaContainer
{
    /**
     * Import Meta from $data array using keys: 'slug','title','description','keywords','heading'
     *
     * @param $data
     * @return $this
     */
    public function metaImport($data);

    /**
     * Export Meta array|object with keys|properties: 'slug','title','description','keywords','heading'
     *
     * @param bool $object
     * @return array|object
     */
    public function metaExport($object = false);

    /**
     * Get Meta values from object
     *
     * @param bool $object
     * @return array|object
     */
    public function metaValues($object = false);
}