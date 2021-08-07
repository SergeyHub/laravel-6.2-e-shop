<?php


namespace App\Http\Admin\Dev;


use AdminDisplay;
use AdminForm;
use AdminFormElement;

class Block extends DeveloperSection
{

    public function initialize()
    {
        $this->title = 'Блоки';
        parent::initialize();
        //

    }

    public function onDisplay()
    {
        $display = \AdminDisplay::datatables();
        $display->setColumns([
            \AdminColumn::text('id','ID'),
            \AdminColumnEditable::text('name')->setLabel('Название (name)'),
            \AdminColumnEditable::text('type')->setLabel('Тип (type)'),
            \AdminColumnEditable::text('key')->setLabel('Ключ (key)'),
            \AdminColumnEditable::checkbox('status')->setLabel('Статус (status)'),
            \AdminColumn::text('country.name', 'Страна')->setSearchable(false),
        ]);
        $display->setDisplaySearch(true);
        return $display;
    }

    public function onEdit()
    {
        $tabs = \AdminDisplay::tabbed();
        $tabs->setTabs(function ($id) {
            $tabs = [];

            //START TAB 0
            $elements = [
                \AdminFormElement::columns()
                    ->addColumn([\AdminFormElement::text('name', 'Название')->required()])
                    ->addColumn([\AdminFormElement::text('type', 'Тип')->required()])
                    ->addColumn([\AdminFormElement::text('key', 'Ключ')->required()])
                    ->addColumn([
                        \AdminFormElement::select('country_id', 'Страна')
                            ->setModelForOptions(\App\Models\Country::class)
                            ->setDisplay('name')
                            ->required(),
                    ]),
                \AdminFormElement::JSON('fields','Поля блока')->setSchema("/js/admin/schema/dynamic_fields.json"),

            ];
            $tabs[] = \AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Основное');
            //END TAB 0
            //START TAB 1
            $elements = [
                \AdminFormElement::JSON('values','Значения полей')->setSchema("/js/admin/schema/dynamic_fields.json"),

            ];
            $tabs[] = \AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Данные');
            //ENd TAB 1
            return $tabs;
        });
        $form = \AdminForm::form()
            ->setElements([
                $tabs
            ]);
        return $form;
    }

}