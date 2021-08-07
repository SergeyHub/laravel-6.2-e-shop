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
 * Class Pages
 *
 * @property \App\Models\Page $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Meta extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Мета теги';
        $this->icon = 'fa fa-bullseye';
    }
    public function isCreatable()
    {
        return false;
    }

    public function isDeletable(Model $model)
    {
        return false;
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
        $display =  AdminDisplay::table()
            ->setColumns([

                AdminColumn::text('name', 'Страница'),
                AdminColumn::text('title', 'Заголовок'),
                AdminColumn::custom('Теги', function(\Illuminate\Database\Eloquent\Model $model) {
                    $content = '';
                    $content .= '<strong>Описание</strong> ';
                    if ($model->description) {
                        $content .= '<span class="label label-success">Да</span><br>';
                    } else {
                        $content .= '<span class="label label-danger">Нет</span><br>';
                    }
                    $content .= '<strong>Ключи</strong> ';
                    if ($model->keywords) {
                        $content .= '<span class="label label-success">Да</span><br>';
                    } else {
                        $content .= '<span class="label label-danger">Нет</span><br>';
                    }
                    return $content ;
                })->setWidth('200px')->setSearchable(false),

                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
            ])
            ->paginate(10);
        //meta CSV import/export
        $display->getActions()->setView('display.actions.meta_actions')->setPlacement('panel.buttons');
        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        if ($id) {
            $item = \App\Models\Meta::find($id);
        }
        $columns = [
            AdminFormElement::html('<h3><strong>'.($id ? $item->name : '').'</strong></h3>'),
            AdminFormElement::html('<div class="text-muted"><strong>Доступны переменные:</strong><br>'.($id ? $item->help : '').'<br><br></div>'),
            AdminFormElement::text('title', 'Заголовок'),
            AdminFormElement::textarea('description', 'Описание')->setRows(3),
            AdminFormElement::text('keywords', 'Ключи'),
        ];
        return AdminForm::panel()->addBody($columns);
    }

}
