<?php

namespace App\Services;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;

readonly class ContactService
{

    public function __construct(
        private MailerInterface $mailer,
    )
    {
    }

    public function proceed(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Create Symfony/Mailer normally
            $email = (new Email())
                ->from('noreply@example.com')
                ->to('admin@example.com')
                ->subject('Asynchronous email !')
                ->html('<b>New message from ' . $data['email'] . '</b><br/><br/><p>' . $data['message'] . '</p>');

            // Email is not send immediately because of config/packages/messenger.yaml
            // Email is added in queue and treat by worker
            $this->mailer->send($email);
            return true;
        }
        return false;
    }
}
