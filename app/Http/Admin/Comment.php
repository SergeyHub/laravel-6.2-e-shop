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
 * Class Comment
 *
 * @property \App\Models\Comment $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Comment extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Комментарии';
        $this->icon = 'fa fa-comments';

    }
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
                //$query->orderBy('order', 'asc');
            })
            ->setOrder([[5, 'desc']])
            ->setColumns([

                \AdminColumnEditable::checkbox('status', 'Отображать', 'Не отображать')->setLabel('Статус')->setEditableMode('inline'),
                AdminColumn::text('blog.title', 'Статья'),
                AdminColumn::text('name', 'Имя'),
                AdminColumn::text('email', 'Email'),
                AdminColumn::text('message', 'Комментарий'),
                AdminColumn::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
            ])
            ->setDisplaySearch(false)
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

            AdminFormElement::checkbox('status')->setLabel('Отображать'),
            AdminFormElement::text('name', 'Имя')->required(),
            AdminFormElement::text('email', 'Email'),
            AdminFormElement::select('blog_id', 'Статья')
                ->setModelForOptions(\App\Models\Blog::class)
                ->setDisplay('title')
                ->required(),
            AdminFormElement::textarea('message', 'Комментарий')
                ->setRows(3),
            AdminFormElement::datetime('created_at','Дата')
                ->setDefaultValue(\Carbon\Carbon::now()),
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
