<?php


namespace App\Http\Admin\Form\Element;


use Illuminate\Http\Request;
use SleepingOwl\Admin\Form\Element\MultiSelect;
use SleepingOwl\Admin\Form\Element\NamedFormElement;
use SleepingOwl\Admin\Form\FormElement;

class MultiSelectTabled extends FormElement
{
    protected $view = "form.element.multiselect-tabled";
    protected $target_model = null;
    protected $target_field = null;
    protected $name = null;
    protected $label = null;
    protected $fields = [];
    protected $order_field = "id";
    protected $order_direction = "asc";
    protected $required = false;
    protected $display_search = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function setModelForOptions($classname)
    {
        $this->target_model = $classname;
        return $this;
    }

    public function setDisplay($fieldname)
    {
        $this->target_field = $fieldname;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setOrder($field, $direction = "asc")
    {
        $this->order_field = $field;
        $this->order_direction = $direction;
        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function setDisplaySearch($bool = true)
    {
        $this->display_search = $bool;
        return $this;
    }

    public function required()
    {
        $this->required = true;
        return $this;
    }

    public function addTargetField($field, $name = null)
    {
        $this->fields[] = (object)["field_name" => $field, "display_name" => $name];
        return $this;
    }

    public function afterSave(Request $request)
    {
        foreach ($this->fields as $field)
        {
            $field_name = $field->field_name;
            $values = $request->get($field_name,[]);
            $this->model->$field_name()->sync($values);
        }
    }

    public function toArray()
    {
        $target_model = $this->target_model;

        if(get_class($this->model) == $target_model)
        {
            $options = $target_model::where("id","<>",$this->model->id)->get();
        }
        else
        {
            $options = $target_model::all();
        }

        if($this->order_direction == "asc")
        {
            $options = $options->sortBy($this->order_field);
        }else
        {
            $options = $options->sortByDesc($this->order_field);
        }

        $return = parent::toArray() + [
                "id"  => $this->model->id,
                "name" => $this->name,
                "label"=>$this->label,
                "option_fieldname" => $this->target_field,
                "display_search" => $this->display_search,
                "required" => $this->required,
                "fields" => $this->fields,
                "options" => $options,

            ];
        return $return;
    }

}
