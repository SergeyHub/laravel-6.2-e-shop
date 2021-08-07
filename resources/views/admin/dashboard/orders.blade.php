<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Последние <a href="/admin/orders">заказы</a></h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin no-head-bg">
                <thead>
                <tr>
                    <th>Код заказа</th>
                    <th>Дата</th>
                    <th>Товары</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    @php
                        /** @var $order \App\Models\Order */
                    @endphp
                    <tr>
                        <td>
                            {{ $order->id }}
                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            @foreach($order->items as $item)
                                <a href="/admin/products/{{$item->product_id}}/edit">{{$item->product->name}}</a> - {{$item->count}} шт.<br>
                            @endforeach
                        </td>
                        <td>{{ $order->price }} ₽</td>
                        <td>
                            @php
                                $status = '';
                                switch ($order->status) {
                                    case 'new':
                                        $status = 'Новый';
                                        break;
                                    case 'complited':
                                        $status = 'Обработан';
                                        break;
                                    default:
                                        $status = $order->status;
                                }
                            @endphp
                            <span class="label label-{{$order->status=="complited"?'success':'info'}}">{{ $status }}</span>
                        </td>
                        <td>
                            <a class="btn btn-primary" style="padding: 0px 11px;" href="/admin/orders/{{$order->id}}/edit">Перейти к заказу</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
