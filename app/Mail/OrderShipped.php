<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

     /**
     * The order instance.
     *
     * @var Order
     */
    protected $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        $title = 'Новый заказ от пользователя '.$order->fio;
        
        return $this->from(getConfigValue('message_from'),$_SERVER['HTTP_HOST'])->subject($title)->view('emails.orders.shipped')->with([
            'order' => $this->order,
        ]);
    }
}
