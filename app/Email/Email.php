<?php

namespace App\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $header;
    public $body;
    public $footer;
    public $details;

    public function header($header)
    {
        $this->header = $header;
    }

    public function body($body)
    {
        $this->body = $body;
    }

    public function footer($footer)
    {
        $this->footer = $footer;
    }

    public function details($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this;
    }
}
