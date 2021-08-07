<?php

namespace App\Http\Admin;

use App\Services\AdminService;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class FilterGroup
 *
 * @property \App\Models\FilterGroup $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class FilterGroup extends Section implements Initializable
{

    public function initialize()
    {
        $this->title = 'Группы фильтров';
        $this->icon = 'fa fa-align-left';

        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
           $this->setSlug($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $this->setSlug($model);
        });
    }

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
            ->setOrder([[5, 'asc']])
            ->setColumns([

                \AdminColumnEditable::text('name')->setLabel('Название'),
                \AdminColumnEditable::checkbox('chained', 'Учавствует в цепочке', 'Не уавствует в цепочке')->setLabel('Построение цепочки sitemap'),
                \AdminColumn::text('alias', 'Алиас'),
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
            \AdminFormElement::text('alias', 'Алиас группы'),
            \AdminFormElement::checkbox('chained', 'Строить цепочку')
        ];

      /*  $elements[] = \AdminFormElement::columns()
            ->addColumn([\AdminFormElement::checkbox('status', 'Доступен')])
            ->addColumn([\AdminFormElement::checkbox('exclude', 'Исключающий фильтр')]);*/

        return \AdminForm::panel()->addBody($elements);
    }

    private function setSlug(&$model)
    {
        $i = 0;
        while(true) {
            $slug = $model->alias ? $model->alias : \Str::slug($model->name, '-');
            if ($i) {
                $slug .= '_'.$i;
            }
            $is = \App\Models\FilterGroup::where('alias', $slug)->where('id', '!=', $model->id)->first();
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
