<?php

namespace App\Http\Admin;

use App\Services\AdminService;
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
class Cities extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Города';
        $this->icon = 'fa fa-fw fa-file-image-o';
        $this->created(function ($config, \Illuminate\Database\Eloquent\Model $model) {
           AdminService::setSlug($model);
        });
        $this->updated(function ($config, \Illuminate\Database\Eloquent\Model $model) {
            AdminService::setSlug($model);
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
        $display = AdminDisplay::datatables()
            ->setApply(function ($query) {
                $query->orderBy('country_id', 'asc');
                $query->orderBy('name', 'asc');
            })
            ->setColumns([
                \AdminColumn::main('name')->setLabel('Название'),
                AdminColumn::text('country.name', 'Страна')->setSearchable(false),
                AdminColumn::text('address', 'Адрес')->setSearchable(false),
                \AdminColumnEditable::checkbox('show_default', 'Да','Нет')
                    ->setLabel('Отображать в списке')
                    ->setSearchable(false),
                AdminColumn::custom('Телефоны', function ($model) {
                    return $model->phone1.'<br>'.$model->phone2;
                })->setSearchable(false),
                //-------------------- status checkbox ------------------------
                \AdminColumnEditable::checkbox('status', 'Да', 'Нет')
                    ->setLabel('Доступен')
                    ->setSearchable(false),
                //-------------------------------------------------------------
                //------------------------ CRM ID -----------------------------
                \AdminColumnEditable::text('remote_id', 'CRM ID')->setSearchable(false),
                //-------------------------------------------------------------
                AdminColumn::datetime('created_at')
                    ->setSearchable(false)
                    ->setLabel('Дата Создания')
                    ->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')
                    ->setLabel('Дата Изменения')
                    ->setFormat('d.m.Y H:i')
                    ->setSearchable(false),
            ])
            ->setDisplaySearch(true)
            ->paginate(3000);
        $display->getActions()->setView('city_actions')->setPlacement('panel.heading.actions');
        return $display;
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
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('name', 'Город %city%')->required()])
                    ->addColumn([AdminFormElement::text('name1', 'Города (Кого?, Чего?) %city1%')])
                    ->addColumn([AdminFormElement::text('name2', 'Городу (Кому?, Чему?) %city2%')]),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('name3', 'Город (Кого?, Что?) %city3%')])
                    ->addColumn([AdminFormElement::text('name4', 'Городом (Кем?, Чем?) %city4%')])
                    ->addColumn([AdminFormElement::text('name5', 'Городе (О ком?, О чем?) %city5%')]),
                //->addColumn([AdminFormElement::text('slug', 'Ссылка')])
                AdminFormElement::text('slug', 'Субдомен'),
                AdminFormElement::select('country_id', 'Страна')->setModelForOptions(\App\Models\Country::class)->setDisplay('name')->required(),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::checkbox('show_default', 'Отображать в списке по умолчанию')])
                    ->addColumn([AdminFormElement::checkbox('use_default', 'Устаносить как город по умолчанию')]),

            ])
        );
        $formFront = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('meta_title', 'Заголовок META'),
                AdminFormElement::textarea('meta_description', 'Описание META'),
                AdminFormElement::text('meta_tags', 'Теги META'),
            ])
        );
        $formContacts = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('phone1', 'Телефон #1')])
                    ->addColumn([AdminFormElement::text('phone2', 'Телефон #2')]),
                    //->addColumn([AdminFormElement::text('email', 'E-mail')]),
                AdminFormElement::textarea('schedule', 'Время работы')->setRows(3),
                AdminFormElement::text('region', 'Регион'),
                AdminFormElement::textarea('address', 'Адрес')->setRows(3),
                //AdminFormElement::textarea('map', 'Код карты')
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('lat_map', 'Широта для карты')])
                    ->addColumn([AdminFormElement::text('lng_map', 'Долгота для карты')]),
                //AdminFormElement::ckeditor('text', 'Текст на странице контакты'),
            ])
        );
        $formRobots = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::textarea('robots', 'Файл robots.txt')->setRows(30)->setHelpText('Если оставить пустым, то будет использоваться файл robots по умолчанию'),
            ])
        );
        $formSitemap = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::textarea('sitemap', 'Адреса карты сайта')->setRows(10)->setHelpText('Каждая ссылка с новой строки. Без указания домена и начального слеша. Если оставить пустым, то будет сгенерирована автоматически.'),
                AdminFormElement::textarea('sitemap_remove', 'Удалить адреса карты сайта')->setRows(10)->setHelpText('При автоматической генерации эти адреса будут исключены. Каждая ссылка с новой строки. Без указания домена и начального слеша.'),
                AdminFormElement::textarea('sitemap_add', 'Добавить адреса карты сайта')->setRows(10)->setHelpText('При автоматической генерации эти адреса будут добавлены. Каждая ссылка с новой строки. Без указания домена и начального слеша.'),
            ])
        );
        $tabs = AdminDisplay::tabbed();
        $tabs->appendTab($formPrimary, 'Общая информация');
        $tabs->appendTab($formFront, 'СЕО');
        $tabs->appendTab($formContacts, 'Контакты');
        $tabs->appendTab($formRobots, 'Файл robots.txt');
        //$tabs->appendTab($formSitemap, 'Файл sitemap.xml');
        return $tabs;
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
