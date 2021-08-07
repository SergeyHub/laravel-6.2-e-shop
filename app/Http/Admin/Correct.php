<?php

namespace App\Http\Admin;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Correct
 *
 * @property \App\Models\Correct $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Correct extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Автозамена';
        $this->icon = 'fa fa-random';

        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $this->setValues($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $this->setValues($model);
        });
    }
    private function setValues(&$model)
    {
        foreach (request()->values ?? [] as $key => $value) {
            \App\Models\CorrectItem::updateOrInsert(
                ['country_id' => $key, 'correct_id' => $model->id],
                ['text' => $value]
            );
        }
    }
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = true;
    function can($action, Model $model)
    {
        return access()->content;
    }

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $columns = [
            AdminColumn::text('name')->setLabel('Название'),
            AdminColumn::custom('Ключ', function(\Illuminate\Database\Eloquent\Model $model) {
                return '%'.$model->key.'%';
            }),
        ];
        $countries = \App\Models\Country::all();
        foreach ($countries as $key => $country) {
            $columns[] = AdminColumn::custom($country->name, function(\Illuminate\Database\Eloquent\Model $model) use($country) {
                $item = $model->items->where('country_id',$country->id)->first();
                return $item ? $item->text : '';
            })->setSearchable(false);
        }
        $columns[] =  AdminColumn::datetime('created_at')
                        ->setLabel('Дата Создания')
                        ->setFormat('d.m.Y H:i')
                        ->setSearchable(false);
        $columns[] =  AdminColumn::datetime('updated_at')
                        ->setLabel('Дата Изменения')
                        ->setFormat('d.m.Y H:i')
                        ->setSearchable(false);
        $columns[] =  AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
            return \App\Services\AdminService::getOrderColumnContent($model,'/admin/categories/');
        })->setWidth('150px')->setOrderable(function($query, $direction) {
            $query->orderBy('order', $direction);
        })->setSearchable(false);

        $display = AdminDisplay::datatables()
                ->setOrder([[5, 'asc']])
                ->setColumns($columns)
                ->setDisplaySearch(true)
                ->paginate(30)
                ->with('items');
        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $model = $id ? \App\Models\Correct::find($id) : null;
        $columns = [
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('key', 'Ключ')->setHelpText('Вводить без %. Использовать как %ключ%'),
            AdminFormElement::html('<hr><h4>Значения</h4>'),
        ];
        $countries = \App\Models\Country::all();
        foreach ($countries as $key => $country) {
            $item = $model ? $model->items->where('country_id',$country->id)->first() : null;
            $columns[] = AdminFormElement::textarea('values['.$country->id.']', $country->name)
                            ->setRows(3)
                            ->setDefaultValue($item ? $item->text : '')
                            ->setValueSkipped(true);
        }
        return AdminForm::panel()->addBody($columns);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }
}
