<?php


namespace App\Http\Admin\Dev;


use AdminDisplay;
use AdminForm;
use AdminFormElement;

class Config extends DeveloperSection
{

    public function initialize()
    {
        $this->title = 'Настройки';
        parent::initialize();
        //

    }

    public function onDisplay()
    {
        $display = \AdminDisplay::datatables();
        $display->setColumns([
            \AdminColumn::text('id','ID')->setOrderable(false),
            \AdminColumnEditable::text('name')->setLabel('Название (name)')->setOrderable(false),
            \AdminColumnEditable::text('type')->setLabel('Тип (type)')->setOrderable(false),
            \AdminColumnEditable::text('key')->setLabel('Ключ (key)')->setOrderable(false),
            \AdminColumn::text('country.name', 'Страна')->setSearchable(false)->setOrderable(false),
        ]);
        $display->setDisplaySearch(true);
        $display->paginate(500);
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
                \AdminFormElement::textarea('help','Текст подсказки'),

            ];
            $tabs[] = \AdminDisplay::tab(AdminForm::elements($elements))->setLabel('Основное');
            //END TAB 0
            return $tabs;
        });
        $form = \AdminForm::form()
            ->setElements([
                $tabs
            ]);
        return $form;
    }

}