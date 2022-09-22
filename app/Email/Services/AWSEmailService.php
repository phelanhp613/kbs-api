<?php

namespace App\Email\Services;

use App\Email\EmailServiceInterface;
use App\Email\Email;
use Illuminate\Support\Facades\Mail;

class AWSEmailService implements EmailServiceInterface
{
    protected $email;

    public function __construct()
    {
        $this->email = new Email();
    }

    public function send($to, $data, $template = 'emails.default-template')
    {
        $email = $this->email;
        $email->view($template);
        if (!empty($data['subject'])) {
            $email->subject($data['subject']);
        }
        if (!empty($data['header'])) {
            $email->header($data['header']);
        }
        if (!empty($data['body'])) {
            $email->body($data['body']);
        }
        if (!empty($data['footer'])) {
            $email->footer($data['footer']);
        }
        if (!empty($data['details'])) {
            $email->details($data['details']);
        }

        Mail::to($to)->send($email);
    }
}
