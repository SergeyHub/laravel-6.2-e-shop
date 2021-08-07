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
 * Class Category
 *
 * @property \App\Models\Category $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Category extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Категории';
        $this->icon = 'fa fa-tags';

        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $this->setSlug($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $this->setSlug($model);
        });
    }
    private function setSlug(&$model)
    {
        $i = 0;
        while(true) {
            $slug = $model->slug ? $model->slug : Str::slug($model->name, '-');
            if ($i) {
                $slug .= '_'.$i;
            }
            $is = \App\Models\Category::where('slug', $slug)->where('id', '!=', $model->id)->first();
            $i++;
            if (!$is) {
                break;
            }
        }
        if (!$model->slug || $i) {
            $model->slug = $slug;
            $model->save();
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
        return AdminDisplay::datatables()
                ->setApply(function ($query) {

                })
                ->setOrder([[5, 'asc']])
                ->setColumns([

                    \AdminColumnEditable::text('name')->setLabel('Название'),
                    \AdminColumnEditable::checkbox('status','Доступен','Не доступен')->setLabel('Статус'),
                    \AdminColumnEditable::checkbox('show_catalog','Отображать','Скрыть')->setLabel('В каталоге'),
                    AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                    AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                    AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
                        return \App\Services\AdminService::getOrderColumnContent($model,'/admin/categories/');
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
        $model = $id ? \App\Models\Category::find($id) : null;
        $columns = [
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::text('product_append', 'Название при выборе категории (отображается в скобках в названии товара)')->required(),
        ];
        $columns[] = AdminFormElement::columns()
                ->addColumn([AdminFormElement::checkbox('status', 'Доступен')])
                ->addColumn([AdminFormElement::checkbox('front', 'Отображать на главной')])
                ->addColumn([AdminFormElement::checkbox('show_catalog', 'Отображать в каталоге')]);
        $columns[] = AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::number('paginate', 'Количество товаров на страницу')
                        ->setDefaultValue(12)
                        ->required()
                ])
                ->addColumn([AdminFormElement::text('front_btn', 'Название кнопки на главной')]);
        $columns[] = AdminFormElement::text('page_title', 'Заголовок страницы');

        $columns[] = AdminFormElement::text('slug', 'Алиас');
        $columns[] = AdminFormElement::text('meta_title', 'Заголовок META');
        $columns[] = AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2);
        $columns[] = AdminFormElement::text('meta_tags', 'Ключи META');

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
