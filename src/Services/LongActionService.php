<?php

namespace App\Services;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class LongActionService
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function proceed(?bool $error = false): void
    {
        sleep(5);
        if($error){
            throw new \Exception("Error during long action");
        }
        $email = (new Email())
            ->from('noreply@example.com')
            ->to('admin@example.com')
            ->subject('Long action is down !')
            ->html('<b>This is long action response</b>');
        $this->mailer->send($email);
    }
}
