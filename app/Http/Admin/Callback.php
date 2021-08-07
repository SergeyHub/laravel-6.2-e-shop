<?php

namespace App\Http\Admin;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use Illuminate\Database\Eloquent\Model;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;

/**
 * Class Callback
 *
 * @property \App\Models\Callback $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Callback extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Обратная связь';
        $this->icon = 'fa fa-reply';

    }
    public function isCreatable()
    {
        return false;
    }

    /* public function isEditable(Model $model)
    {
        return false;
    } */
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = true;
    function can($action, Model $model)
    {
        return access()->manager;
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
                $query->orderBy('id', 'desc');
            })
            ->setColumns([

                AdminColumn::text('id', '#'),
                AdminColumn::text('created_at', 'Дата'),
                AdminColumn::text('country.name', 'Страна'),
                \AdminColumnEditable::checkbox('status', 'Обработан', 'Не обработан')->setLabel('Статус')->setEditableMode('inline'),
                AdminColumn::text('type', 'Форма'),
                AdminColumn::custom('Клиент', function ($callback) {
                    $res = '';
                    $res .= 'Имя: ' . $callback->name . '<br>';
                    $res .= 'телефон: ' . $callback->phone . '<br>';
                    if ($callback->city)
                    $res .= 'город: ' . $callback->city . '<br>';
                    if ($callback->email)
                        $res .= 'Email: ' . $callback->email . '<br>';
                    $res .= 'IP: ' . $callback->ip;
                    return $res;
                }),
                \AdminColumnEditable::textarea('message', 'Сообщение'),
                AdminColumn::custom('Вложение',function ($model)
                {
                    $text = '';
                    if ($model->files && count($model->files)) {
                        foreach ($model->files as $key => $file) {

                            $text.= '<a href="/admin/download/callback/'.$model->id.'/'.$key.'">'.\basename($file).'</a><br>';
                        }
                    }
                    return $text;
                }),
                AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
            ])
            ->setDisplaySearch(true)
            ->paginate(10);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $columns = [
            AdminFormElement::select('country_id', 'Страна')->setModelForOptions(\App\Models\Country::class)->setDisplay('name'),
            AdminFormElement::checkbox('status', 'Обработан', 'Не обработан')->setLabel('Обработан'),
            AdminFormElement::datetime('created_at', 'Дата'),
            AdminFormElement::text('name', 'ФИО'),
            AdminFormElement::text('phone', 'Телефон'),
            AdminFormElement::text('city', 'Город'),
            AdminFormElement::text('email', 'email'),
            AdminFormElement::textarea('message', 'Сообщение'),
            AdminFormElement::text('ip', 'IP'),
            /*AdminFormElement::text('meta_title', 'Заголовок META'),
            AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2),
            AdminFormElement::text('meta_tags', 'Ключи META'), */
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

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
