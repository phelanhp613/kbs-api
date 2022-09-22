<?php

namespace App\Email;

interface EmailServiceInterface
{
    public function send($to, $data, $template = 'emails.default-template');
}
