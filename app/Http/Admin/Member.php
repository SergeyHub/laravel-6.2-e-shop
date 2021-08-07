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
 * Class Member
 *
 * @property \App\Models\Member $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Member extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Сотрудники';
        $this->icon = 'fa fa-users';
        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {

        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {

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
                //$query->orderBy('created_at', 'desc');
            })
            ->setOrder([[6, 'asc']])
            ->setColumns([
                \AdminColumnEditable::checkbox('status','Доступен','Не доступен')->setLabel('Статус'),
                AdminColumn::text('name')->setLabel('Имя'),
                AdminColumn::text('position')->setLabel('Должность'),
                AdminColumn::text('email')->setLabel('E-mail'),
                AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
                AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
                    return \App\Services\AdminService::getOrderColumnContent($model,'/admin/members/');
                })->setWidth('150px')->setOrderable(function($query, $direction) {
                    $query->orderBy('order', $direction);
                })->setSearchable(false),
            ])
            //->setDisplaySearch(true)
            ->paginate(50);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {

        $tabs = AdminDisplay::tabbed();
        $tabs->setTabs(function () use($id) {
            $tabs = [];

            $elements = [
                AdminFormElement::text('name', 'Имя')->required(),
                AdminFormElement::text('position', 'Должность'),
                AdminFormElement::text('email', 'E-mail'),
                AdminFormElement::image('image', 'Аватар'),
            ];

            $tabs[] = AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Содержимое');

            return $tabs;
        });
        return AdminForm::form()->addElement($tabs);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
    /**
     * @return FormInterface
     */
    public function onDelete()
    {

    }
}
