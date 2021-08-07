<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Comment extends Mailable
{
    use Queueable, SerializesModels;

    protected $user_name;
    protected $comment_type;
    protected $comment_text;
    protected $edit_link;
    protected $site_domain;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $type, $text, $edit_link)
    {
        $this->user_name = $name;
        $this->comment_type = $type;
        $this->comment_text = $text;
        $this->site_domain = country()->domain;
        $this->edit_link = request()->getScheme() ."://". $this->site_domain . $edit_link;
    }

    /**
     * Build the message.
     *
     * @return \App\Mail\Comment
     */
    public function build()
    {
        $title = $this->comment_type . ' от ' . $this->user_name;

        return $this
            ->from(getConfigValue('message_from'), $_SERVER['HTTP_HOST'])
            ->subject($title)
            ->view('emails.question.any')
            ->with([
                'name' => $this->user_name,
                'type' => $this->comment_type,
                'text' => $this->comment_text,
                'domain' => $this->site_domain,
                'link' => $this->edit_link,
                'title' => $title
            ]);
    }
}
