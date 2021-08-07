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
 * Class Order
 *
 * @property \App\Models\Order $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Order extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Заказы';
        $this->icon = 'fa fa-shopping-cart';

    }
    public function isCreatable()
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
                $query->orderBy('id', 'desc');
            })
            ->setColumns([

                AdminColumn::text('id', '#'),
                AdminColumn::text('date', 'Дата'),
                AdminColumn::text('country.name', 'Страна'),
                AdminColumn::custom('Статус', function ($order) {
                    $res = '';
                    switch ($order->status) {
                        case 'new':
                            $res = '<span class="label label-info">Новый</span>';
                            break;
                        case 'complited':
                            $res = '<span class="label label-success">Обработан</span>';
                            break;
                        default:
                            $res = '<span class="label label-default">'. $order->status .'</span>';
                            break;
                    }
                    return $res;
                }),
                AdminColumn::text('type', 'Тип'),
                AdminColumn::custom('Клиент', function ($order) {
                    $res = '';
                    $res.= 'ФИО: ' .$order->fio.'<br>';
                    $res.= 'телефон: ' .$order->phone.'<br>';
                    $res.= 'город: ' .$order->city.'<br>';
                    if($order->address)
                        $res.= 'адрес: ' .$order->address.'<br>';
                    $res.= 'комментарий: ' .$order->comment;
                    return $res;
                }),
                AdminColumn::custom('Товары', function ($order) {
                    $res = '';

                    foreach($order->items as $item) {
                        $res .= '<a href="/admin/products/'.$item->product_id.'/edit">'.$item->product->name. '</a>  (' . $item->price . ' '.$order->country->currency.')  - '.$item->count.' шт.<br>';
                    }
                    return $res;
                }),
                AdminColumn::custom('Способ доставки', function ($order) {
                    $res = '';
                    switch ($order->delivery) {
                        case 'pickup':
                            $res = 'Самовывоз';
                            break;
                        case 'address':
                            $res = 'Курьерская доставка';
                            break;
                        case 'post':
                            $res = 'Почта России';
                            break;
                        default:
                    }
                    return $res;
                }),
                \AdminColumnEditable::text('price', 'Цена'),
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
        $item = $id ? \App\Models\Order::find($id) : false;
        $type = $item->type;
        $columns = [
            AdminFormElement::select('country_id', 'Страна')->setModelForOptions(\App\Models\Country::class)->setDisplay('name'),
            AdminFormElement::select('status', 'Статус',['new'=>'Новый','complited'=>'Обработан']),
            AdminFormElement::datetime('date', 'Дата'),
            AdminFormElement::select('delivery', 'Способ доставки', ['pickup' => 'Самовывоз', 'address' => 'Курьерская доставка', 'post' => 'Почта России']),
            AdminFormElement::number('price', 'Цена'),
            AdminFormElement::text('fio', 'ФИО'),
            AdminFormElement::text('phone', 'Телефон'),
            AdminFormElement::text('city', 'Город'),
            AdminFormElement::text('address', 'Адрес'),
            AdminFormElement::text('comment', 'Комментарий'),
            /*AdminFormElement::text('meta_title', 'Заголовок META'),
            AdminFormElement::textarea('meta_description', 'Описание META')->setRows(2),
            AdminFormElement::text('meta_tags', 'Ключи META'), */
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
