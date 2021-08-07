<?php


namespace App\Http\Admin\Form\Element;


use SleepingOwl\Admin\Form\Element\Textarea;

class Json extends Textarea
{
    protected $view = 'form.element.json';
    protected $schema = null;

    public function setSchema($path)
    {
        $this->schema = $path;
        return $this;
    }

    public function getValueFromModel()
    {
        $value = parent::getValueFromModel();
        //dd($value);
        $encoded = json_encode(json_decode($value),JSON_UNESCAPED_UNICODE);
        return $encoded;
    }

    public function toArray()
    {
        $this->setHtmlAttributes([
            'class' => 'form-control',
            'rows' => $this->getRows(),
        ]);

        return parent::toArray() + [
                'schema' => $this->schema,
            ];
    }
}