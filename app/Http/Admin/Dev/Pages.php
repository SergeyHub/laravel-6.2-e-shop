<?php


namespace App\Http\Admin\Dev;


use AdminDisplay;
use AdminForm;
use AdminFormElement;

class Pages extends DeveloperSection
{

    public function initialize()
    {
        $this->title = 'Страницы';
        parent::initialize();
        //

    }

    public function onDisplay()
    {
        $display = \AdminDisplay::datatables();
        $display->setColumns([
            \AdminColumn::text('id','ID')->setOrderable(false),
            \AdminColumnEditable::text('title')->setLabel('Название (title)')->setOrderable(false),
            \AdminColumnEditable::text('type')->setLabel('Тип (type)')->setOrderable(false),
            \AdminColumnEditable::text('slug')->setLabel('Алиас (slug)')->setOrderable(false),
            \AdminColumnEditable::text('view')->setLabel('Шаблон (view)')->setOrderable(false),
            \AdminColumn::text('country.name', 'Страна')->setOrderable(false)->setSearchable(false),
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
                    ->addColumn([\AdminFormElement::text('title', 'Название')->required()])
                    ->addColumn([\AdminFormElement::text('type', 'Тип')->required()])
                    ->addColumn([\AdminFormElement::text('slug', 'Алиас')->required()])
                    ->addColumn([
                        \AdminFormElement::select('country_id', 'Страна')
                            ->setModelForOptions(\App\Models\Country::class)
                            ->setDisplay('name')
                            ->required(),
                    ]),

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