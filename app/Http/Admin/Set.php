<?php

namespace App\Http\Admin;

use App\Services\AdminService;
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
 * Class Set
 *
 * @property \App\Models\Set $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Set extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Подборки (Теги)';
        $this->icon = 'fa fa-tags';

        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            AdminService::setSlug($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
           AdminService::setSlug($model);
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
        return AdminDisplay::datatables()
                ->setApply(function ($query) {

                })
                ->setOrder([[4, 'asc']])
                ->setColumns([

                    \AdminColumn::main('name')->setLabel('Название'),
                    \AdminColumnEditable::checkbox('status','Доступен','Не доступен')->setLabel('Статус'),
                    AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                    AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                    AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
                        return \App\Services\AdminService::getOrderColumnContent($model,'/admin/sets/');
                    })->setWidth('150px')->setOrderable(function($query, $direction) {
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
        $model = $id ? \App\Models\Set::find($id) : null;
        $tabs = AdminDisplay::tabbed();
        $tabs->setTabs(function ($id) use ($model) {
            //----------------- TAB 1 -------------------
            $elements = [];
            $elements[] = AdminFormElement::text('name', 'Название')->required();
            $elements[] = AdminFormElement::checkbox('status', 'Доступна')->setDefaultValue(1);
            $elements[] = AdminFormElement::text('slug', 'Алиас');
            $elements[] = AdminFormElement::text('meta_title', 'Заголовок META');
            $elements[] = AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2);
            $elements[] = AdminFormElement::text('meta_tags', 'Ключи META');
            $tabs[] = AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Основное');

            //---------------- TAB 2 ----------------------
            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::multiselectTabled()
                    ->setLabel("Товары")
                    ->addTargetField("Products")
                    ->setModelForOptions(\App\Models\Product::class)
                    ->setDisplay('name')
                    ->setName('Товары')
            ]))->setLabel('Товары');

            //---------------- TAB 3 ----------------------
            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::multiselectTabled()
                    ->setLabel("Категории")
                    ->addTargetField("categories")
                    ->setModelForOptions(\App\Models\Category::class)
                    ->setDisplay('name')
                    ->setName('Категории')
                    ->setOrder("name")
            ]))->setLabel('Категории');
            return $tabs;
        });


        return AdminForm::panel()->addBody($tabs);
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
