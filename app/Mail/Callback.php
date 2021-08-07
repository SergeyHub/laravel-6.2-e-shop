<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Callback extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Callback $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $callback = $this->callback;
        if ($callback->type == 'Перезвоните мне' || true) {
            $title = 'Новая заявка "Позвоните мне" от пользователя '.$callback->name;
        } else {
            $title = 'Новая заявка "'.$callback->type.'" от пользователя '.$callback->email;
        }
        return $this->from(getConfigValue('message_from'),$_SERVER['HTTP_HOST'])->subject($title)->view('emails.callbacks.store')->with([
            'callback' => $this->callback,
        ]); 
    }
}
