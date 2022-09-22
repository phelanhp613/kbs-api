<?php

namespace App\Email;

class EmailDecorator implements EmailServiceInterface
{
    protected $emailServiceInterface;

    public function __construct(EmailServiceInterface $interface)
    {
        $this->emailServiceInterface = $interface;
    }

    public function send($to, $data, $template = 'emails.default-template')
    {
        $this->emailServiceInterface->send($to, $data, $template);
    }
}
