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
use App\Mail\Answer;
use Illuminate\Support\Facades\Mail;
/**
 * Class Pages
 *
 * @property \App\Models\Page $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Question extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Вопросы';
        $this->icon = 'fa fa-question';
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            if ($model->answer && $model->status && !$model->mail_hash) {
                $model->mail_hash = md5($model->id.$model->answer.time());
                $model->save();
                Mail::to($model->email)->send(new Answer($model));
                \SleepingOwl\Admin\Facades\MessageStack::addSuccess('Отправлено уведоемление на адрес '.$model->email);
            }
        });
    }
    public function isCreatable()
    {
        return true;
    }

    public function isDeletable(Model $model)
    {
        return true;
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
            ->setOrder([[5, 'desc']])
            ->setColumns([

                AdminColumn::text('product.name', 'Товар')->setSearchable(false),
                \AdminColumnEditable::checkbox('status','Опубликован', 'Не опубликован'),
                AdminColumn::text('title', 'Заголовок'),
                AdminColumn::text('question','Вопрос'),
                AdminColumn::custom('Есть ответ',function(\Illuminate\Database\Eloquent\Model $model) {
                    return strip_tags($model->answer) ?
                            '<span class="label label-success">Да</span>' :
                            '<span class="label label-danger">Нет</span>';
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
        if ($id) {
            $item = \App\Models\Question::find($id);
        }
        $columns = [
            AdminFormElement::checkbox('status', 'Опубликован'),
            AdminFormElement::select('product_id', 'Товар')
                ->setModelForOptions(\App\Models\Product::class)
                ->setDisplay('name')
                ->required(true),
            AdminFormElement::columns()
                ->addColumn([AdminFormElement::text('name', 'Имя')])
                ->addColumn([AdminFormElement::text('email', 'Email')]),
            AdminFormElement::text('title', 'Заголовок'),
            AdminFormElement::textarea('question','Вопрос'),
            AdminFormElement::ckeditor('answer', 'Ответ'),
            AdminFormElement::image('image', 'Аватарка'),
        ];
        return AdminForm::panel()->addBody($columns);
    }
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
