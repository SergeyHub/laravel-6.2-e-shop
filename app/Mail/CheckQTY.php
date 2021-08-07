<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Callback;

class CheckQTY extends Mailable
{
    use Queueable, SerializesModels;

    private $callback;
    private $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function  __construct($product,  Callback $callback)
    {
        $this->callback = $callback;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(getConfigValue('message_from'),$_SERVER['HTTP_HOST'])->subject("Перезвон по наличию")->view('emails.callbacks.qty')->with([
            'callback' => $this->callback,
            'product' => $this->product
        ]);
    }
}
