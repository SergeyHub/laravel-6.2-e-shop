<?php

namespace App\Http\Admin;

use App\Http\Admin\Display\Extensions\DisplayFilterButtons;
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
 * Class Review
 *
 * @property \App\Models\Review $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Review extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Отзывы';
        $this->icon = 'fa fa-fw fa-quote-right';

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
        $display = AdminDisplay::datatables()
            ->setApply(function ($query) {
                //$query->orderBy('order', 'asc');
            })
            ->setOrder([5, 'asc'])
            ->setColumns([

                AdminColumn::image('image', 'Фото'),
                \AdminColumnEditable::checkbox('status', 'Отображать', 'Не отображать')->setLabel('Статус')->setEditableMode('inline'),
                AdminColumn::text('product.name', 'Продукт'),
                \AdminColumnEditable::text('name', 'Имя'),
                \AdminColumnEditable::text('phone', 'Телефон'),
                \AdminColumnEditable::datetime('created_at')->setLabel('Дата Создания')->setFormat('d.m.Y H:i'),
                AdminColumn::datetime('updated_at')->setLabel('Дата Изменения')->setFormat('d.m.Y H:i'),
           /*     AdminColumn::custom('Положение', function(\Illuminate\Database\Eloquent\Model $model) {
                    return \App\Services\AdminService::getOrderColumnContent($model,'/admin/reviews/');
                })->setWidth('150px')->setOrderable(function($query, $direction) {
                    $query->orderBy('order', $direction);
                })->setSearchable(false),*/
            ])
            ->setDisplaySearch(false)
            ->paginate(50);
        //------------------- FILTERS ------------------------//
        $display->extend('display_filter_buttons', new DisplayFilterButtons());
        $display->setDisplayFilterButtons([
            'status' => 'Не опубликованные',
        ]);
        $display->setFilters([
            //
            \AdminDisplayFilter::custom('status')->setCallback(function ($query, $value) {
                $query->where("status",0)->orderBy('created_at', 'asc');
            })->setTitle('Не опубликовано'),
        ]);
        //reviews actions
        $display->getActions()->setView('display.actions.reviews_actions')->setPlacement('panel.buttons');
        return $display;
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
            AdminFormElement::text('name', 'Имя'),
            AdminFormElement::text('phone', 'Телефон'),
            AdminFormElement::text('rate', 'Рейтинг')->setHelpText('Количество звезд. Целое число от 1 до 5'),
            AdminFormElement::select('product_id', 'Продукт')->setModelForOptions(\App\Models\Product::class)->setDisplay('name'),
            /* AdminFormElement::text('link_fb', 'Ссылка фейсбук'),
            AdminFormElement::text('link_vk', 'Ссылка Вконтакте'),
            AdminFormElement::text('link_insta', 'Ссылка Инстаграм'), */
            //AdminFormElement::ckeditor('message', 'Короткий текст'),
            AdminFormElement::ckeditor('message_full', 'Полный текст'),
            AdminFormElement::datetime('created_at', 'Дата публикации'),
            AdminFormElement::image('image', 'Картинка'),
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
