<?php


namespace App\Http\Admin\Form\Element;


use App\Models\Country;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Form\Element\NamedFormElement;
use SleepingOwl\Admin\Form\FormElement;

class Prices extends FormElement
{
    protected $view = "form.element.prices";
    protected $name = null;
    protected $label = null;
    protected $fields = [];
    protected $countries = null;
    protected $helpText = null;
    protected $required = false;
    protected $step = 10;

    public function __construct($label)
    {
        parent::__construct();
        $this->label = $label;
        $this->countries = Country::all();
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function required()
    {
        $this->required = true;
        return $this;
    }

    public function addField($qty, $label = null)
    {
        $this->fields[$qty] = [
            "name" => $label,
            "fields" => []
        ];
        foreach ($this->countries as $country) {
            $this->fields[$qty]["fields"][$country->id] = [

                "name" => "prices_" . $qty . "_" . $country->id,
                "currency" => $country->currency

            ];
        }
        return $this;
    }

    public function setStep($value)
    {
        $this->step = $value;
		return $this;
    }

    /**
     * @return string
     */
    public function getHelpText()
    {
        if ($this->helpText instanceof Htmlable) {
            return $this->helpText->toHtml();
        }

        return $this->helpText;
    }

    /**
     * @param string|Htmlable $helpText
     *
     * @return $this
     */
    public function setHelpText($helpText)
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function afterSave(Request $request)
    {
        foreach ($this->fields as $qty => $qty_field) {
            foreach ($qty_field['fields'] as $country_id => $country_field) {
                $value = $request->get("prices_" . $qty . "_" . $country_id, 0);
                $this->model->setPrice($value, $qty, $country_id);
            }
        }
    }

    public function toArray()
    {
        $return = parent::toArray() + [
                "id" => $this->model->id,
                "name" => $this->name,
                "label" => $this->label,
                "countries" => $this->countries,
                "required" => $this->required,
                "fields" => $this->fields,
				"step" => $this->step,
                "helpText"=>$this->helpText
            ];
        return $return;
    }
}