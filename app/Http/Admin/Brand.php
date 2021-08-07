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
 * Class Brand
 *
 * @property \App\Models\Brand $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Brand extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Бренды';
        $this->icon = 'fa fa-certificate';
        $this->creating(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            /** @var $model \App\Models\City */
            if (!$model->slug) {
                $model->slug = Str::slug($model->name, '-');
            }
        });
        $this->updating(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            /** @var $model \App\Models\City */
            if (!$model->slug) {
                $model->slug = Str::slug($model->name, '-');
            }
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
                //$query->orderBy('order', 'asc');
            })
            ->setOrder([[4, 'asc']])
            ->setColumns([
                \AdminColumn::main('name')->setLabel('Название'),
                \AdminColumnEditable::text('slug')->setLabel('Алиас'),
                \AdminColumnEditable::checkbox('status','Доступен','Не доступен')->setLabel('Статус'),
                AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
                    return \App\Services\AdminService::getOrderColumnContent($model,'/admin/products/');
                })->setWidth('150px')->setOrderable(function($query, $direction) {
                    $query->orderBy('order', $direction);
                })->setSearchable(false),
            ])
            ->setDisplaySearch(true)
            ->paginate(50);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $columns = [
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::number('paginate', 'Количество товаров на страницу'),
            AdminFormElement::text('slug', 'Алиас'),
            AdminFormElement::text('page_title', 'Заголовок страницы'),
            AdminFormElement::text('meta_title', 'Заголовок META')->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
            AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2)->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
            AdminFormElement::text('meta_tags', 'Ключи META')->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
        ];

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
