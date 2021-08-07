<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Question extends Mailable
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
        $question = $this->question;

        $title = 'Новый вопрос от пользователя '.$question->email;

        return $this->from(getConfigValue('message_from'),$_SERVER['HTTP_HOST'])->subject($title)->view('emails.question.store')->with([
            'question' => $this->question,
        ]);
    }
}
