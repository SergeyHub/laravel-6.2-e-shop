<?php


namespace App\Http\Admin\Form\Element;


use App\Models\FilterGroup;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Form\FormElement;

class Filters extends FormElement
{
    protected $view = "form.element.filters";

    protected $name = null;
    protected $label = null;
    protected $helpText = null;
    protected $groups = null;

    public function __construct($name, $label = null)
    {
        parent::__construct();
        $this->name = $name;
        $this->label = $label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function setFilterGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }

    public function setHelpText($helpText)
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function afterSave(Request $request)
    {
        $filed = $this->name;
        $this->model->$filed()->sync($request->get("filters",[]));
    }

    public function toArray()
    {
        $field = $this->name;
        $return = parent::toArray() + [
                "filters" => $this->model->$field,
                "groups" => $this->groups ?? FilterGroup::orderBy("order")->get(),
                "name"  => $this->name,
                "label" => $this->label,
                "helpText"=>$this->helpText
            ];
        return $return;
    }
}
