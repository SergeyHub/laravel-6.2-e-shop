<?php

namespace App\Http\Admin;

use App\Services\AdminService;
use App\Services\CatalogService;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Filter
 *
 * @property \App\Models\Filter $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Filter extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Фильтры (Кластеры)';
        $this->icon = 'fa fa-tags';

        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
           $this->setSlug($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $this->setSlug($model);
        });
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
        return \AdminDisplay::datatables()
            ->setApply(function ($query) {

            })
            ->setOrder([[6, 'asc']])
            ->setColumns([

                \AdminColumnEditable::text('name')->setLabel('Название'),
                \AdminColumnEditable::checkbox('status', 'Доступен', 'Не доступен')->setLabel('Статус'),
                \AdminColumn::text('alias', 'Алиас'),
                \AdminColumn::text('group.name', 'Группа фильтров'),
                \AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                \AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                \AdminColumn::custom('Положение', function (\Illuminate\Database\Eloquent\Model $model) {
                    return \App\Services\AdminService::getOrderColumnContent($model, '/admin/categories/');
                })->setWidth('150px')->setOrderable(function ($query, $direction) {
                    $query->orderBy('order', $direction);
                })->setSearchable(false),
            ])
            ->paginate(30);
    }

    private function setSlug(&$model)
    {
        $i = 0;
        while(true) {
            $slug = $model->alias ? $model->alias : \Str::slug($model->name, '-');
            if ($i) {
                $slug .= '_'.$i;
            }
            $is = \App\Models\Filter::where('alias', $slug)->where('id', '!=', $model->id)->first();
            $i++;
            if (!$is) {
                break;
            }
        }
        if (!$model->alias || $i) {
            $model->alias = $slug;
            $model->save();
        }
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $model = $id ? \App\Models\Category::find($id) : null;
        $elements = [
            \AdminFormElement::text('name', 'Название')
                ->required(),
            \AdminFormElement::text('alias', 'Алиас цепочки'),
            \AdminFormElement::text('chain_append', 'Дополнение к %chain%')
                ->required(),
        ];
        $elements[] = \AdminFormElement::select("filter_group_id", "Группа фильтров")
            ->setModelForOptions(\App\Models\FilterGroup::class)
            ->setDisplay("name_ordered")
            ->required();

        $elements[] = \AdminFormElement::columns()
            ->addColumn([\AdminFormElement::checkbox('status', 'Доступен')])
            ->addColumn([\AdminFormElement::checkbox('front', 'Отображать на главной')]);


        return \AdminForm::panel()->addBody($elements);
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
