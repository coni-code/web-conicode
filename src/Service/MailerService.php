<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private readonly string $contactEmail)
    {
    }

    public function sendContactUsData(array $data, MailerInterface $mailer): void
    {
        $email = (new Email())
            ->from($data['email'])
            ->to($this->contactEmail)
            ->subject('Wiadomość z formularza kontaktowego')
            ->text('Nadawca: ' . $data['email'] . "\n\nWiadomość:\n" . $data['body']);

        $mailer->send($email);
    }
}
