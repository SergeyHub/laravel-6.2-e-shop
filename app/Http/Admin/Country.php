<?php

namespace App\Http\Admin;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Support\Str;
//use SleepingOwl\Admin\Form\FormElements;
/**
 * Class Cities
 *
 * @property \App\City $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Country extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Страны';
        $this->icon = 'fa fa-fw fa-map-marker';
        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            $blocks = \App\Models\Block::where('country_id',1)->get();
            foreach ($blocks as $key => $item) {
                $new_item = $item->replicate();
                $new_item->country_id = $model->id;
                $new_item->push();
            }
            $blocks = \App\Models\Page::where('country_id',1)->get();
            foreach ($blocks as $key => $item) {
                $new_item = $item->replicate();
                $new_item->country_id = $model->id;
                $new_item->push();
            }
            $blocks = \App\Models\Config::where('country_id',1)->get();
            foreach ($blocks as $key => $item) {
                $new_item = $item->replicate();
                $new_item->country_id = $model->id;
                $new_item->push();
            }
        });
        $this->updating(function ($config, \Illuminate\Database\Eloquent\Model $model) {

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

            ->setColumns([
                AdminColumn::text('name', 'Название'),
                AdminColumn::text('code', 'Код страны'),
                AdminColumn::text('domain', 'Домен'),
                AdminColumn::text('currency', 'Название валюты'),
                AdminColumn::text('rate', 'Курс'),
                \AdminColumnEditable::checkbox('status','Доступна','Не доступна')->setLabel('Статус'),
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
        $formPrimary = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('name', 'Название')->required(),
                AdminFormElement::text('code', 'Код страны')->required()->setHelpText('Двухбуквенный код страны по ISO 3166-1. Пример RU'),
                AdminFormElement::text('domain', 'Домен')->required()->setHelpText('Без протокола и закрывающего слеша. Пример: lolland.ru'),
                AdminFormElement::text('currency', 'Название валюты')->setHelpText('Отображается после цены'),
                AdminFormElement::text('rate', 'Курс валюты'),

            ])
        );
        $tabs = AdminDisplay::tabbed();
        $tabs->appendTab($formPrimary, 'Общая информация');
        return $tabs;
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
