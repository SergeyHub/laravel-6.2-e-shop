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
 * Class Video
 *
 * @property \App\Models\Video $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Video extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Видео';
        $this->icon = 'fa fa-camera';
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
                $query->orderBy('order', 'asc');
            })
            ->setColumns([
                /* AdminColumn::image('image', 'Изображение'), */
                \AdminColumnEditable::text('name')->setLabel('Название'),
                \AdminColumnEditable::text('remote_id')->setLabel('ID на youtube'),
                \AdminColumnEditable::checkbox('status')->setLabel('Опубликовано'),
                \AdminColumnEditable::checkbox('promotion')->setLabel('На главной'),
                /* \AdminColumnEditable::text('slug')->setLabel('Алиас'), */
                AdminColumn::order()->setLabel('Положение'),
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
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::text('remote_id', 'ID видео на youtube')->required(),
            AdminFormElement::image('image', 'Изображение')->setHelpText('Если не указано, то картинка будет взята с ютюба'),
            AdminFormElement::checkbox('status', 'Опубликовано'),
            AdminFormElement::checkbox('promotion', 'Отображать на главной'),
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
