<?php

namespace App\Http\Admin;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use Illuminate\Database\Eloquent\Model;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;

/**
 * Class Config
 *
 * @property \App\Models\Config $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Config extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Настройки';
        $this->icon = 'fa fa-cogs';

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
        return AdminDisplay::table()
            ->setApply(function ($query) {
                $query->orderBy('name', 'asc');
            })
            ->setColumns([
                AdminColumn::text('country.name', 'Страна'),
                \AdminColumnEditable::text('name')->setLabel('Название'),
                AdminColumn::text('value')->setLabel('Значение'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
            ])
            ->disablePagination();
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $item = $id ? \App\Models\Config::find($id) : false;
        $type = $item->type;
        $columns = [
            AdminFormElement::html('<p><strong>Страна:</strong> '.$item->country->name.'</p>'),
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::$type('value', 'Значение')->setHelpText($item->help),
            /*AdminFormElement::text('meta_title', 'Заголовок META'),
            AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2),
            AdminFormElement::text('meta_tags', 'Ключи META'), */
        ];
        return AdminForm::panel()->addBody($columns);
    }

    public function isCreatable()
    {
        return false;
    }

    public function isDeletable(Model $model)
    {
        return false;
    }
}
