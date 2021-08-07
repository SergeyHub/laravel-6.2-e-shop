<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Answer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Мы ответили на Ваш вопрос';
        return $this->from(getConfigValue('message_from'),$_SERVER['HTTP_HOST'])->subject($title)
            ->markdown('emails.question.answer')->with([
                'question' => $this->question,
            ]);
    }
}
