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
use \App\Models\Page;
/**
 * Class Pages
 *
 * @property \App\Models\Page $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Pages extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Страницы';
        $this->icon = 'fa fa-list';
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            /** @var $model \App\Models\Page */
            $this->saveValues($model);
        });
    }
    public function saveValues(&$model)
    {
        $model->data = request()->fields;
        $model->save();
    }
    public function isCreatable()
    {
        return true;
    }

    public function isDeletable(Model $model)
    {
        return $model->id > 10;
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
                AdminColumn::text('country.name', 'Страна'),
                \AdminColumnEditable::checkbox('status','Доступна','Не доступна')->setLabel('Статус'),
                AdminColumn::main('title', 'Заголовок'),
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
        $tabs = AdminDisplay::tabbed();
        $page = $id ? Page::find($id) : null;
        $tabs->setTabs(function () use($id, $page) {
            $tabs = [];

            $view = $page ? $page->view : null;
            switch ($view) {
                case 'page.about':
                    $elements = [
                        AdminFormElement::text('title', 'Заголовок')->required(),
                        AdminFormElement::ckeditor('body', 'Содержимое'),
                        AdminFormElement::textarea('fields[details]', 'Реквизиты')
                            ->setValueSkipped(true)
                            ->setDefaultValue($page->data['details'] ?? '')
                            ->setHelpText('Каждый элемент с новой строки. Название - Значение разделять символом |'),
                    ];
                    break;
                case 'page.contact':
                    $elements = [
                        AdminFormElement::text('title', 'Заголовок')->required(),
                        AdminFormElement::textarea('body', 'Содержимое'),
                    ];
                    break;
                case 'page.delivery':
                    $elements = [
                        AdminFormElement::text('title', 'Заголовок')->required(),
                        AdminFormElement::ckeditor('body', 'Содержимое'),
                    ];
                    break;

                default:
                    $prefix = 'fields';
                    $title = 'Поля';

                    $items = $page->data ?? [];

                    $products = \App\Models\Product::orderBy('name')->pluck('name','id')->toArray();
                    $elements = [
                        AdminFormElement::text('title', 'Заголовок')->required(),
                        AdminFormElement::html('<div class="clearfix"></div>'),
                        AdminFormElement::view('admin.multi_fields',compact('items','prefix','title','products')),
                        AdminFormElement::html('<div class="clearfix"></div>'),
                    ];
                    break;
            }
            $tabs[] = AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Содержимое');

            $tabs[] = AdminDisplay::tab(new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('slug', 'Алиас'),
                AdminFormElement::text('meta_title', 'Заголовок META')->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
                AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2)->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
                AdminFormElement::text('meta_tags', 'Ключи META')->setHelpText('Доступны переменные: %brand% -> Имя производителя, %category% -> Имя категории. %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%'),
            ]))->setLabel('SEO');

            return $tabs;
        });
        return AdminForm::form()->addElement(AdminFormElement::html(view('admin.instance_actions',['href'=>"/".$page->slug])))->addElement($tabs);
    }

}
