<?php

namespace App\Email;

use App\Email\Services\AWSEmailService;
use App\Email\Services\SendGridEmailService;
use App\Email\Services\SMTPEmailService;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $service = config('mail.zen_mail_provider');
        $this->app->bind(
            EmailServiceInterface::class,
            function ($app) use ($service) {
                if ($service == 'amazon') {
                    return $app->make(EmailDecorator::class, ['interface' => $app->make(AWSEmailService::class)]);
                } elseif ($service == 'send-grid') {
                    return $app->make(EmailDecorator::class, ['interface' => $app->make(SendGridEmailService::class)]);
                }

                return $app->make(EmailDecorator::class, ['interface' => $app->make(SMTPEmailService::class)]);
            }
        );
    }
}
