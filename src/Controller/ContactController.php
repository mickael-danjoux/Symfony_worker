<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class)->handleRequest($request);
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
            $mailer->send($email);

            $this->addFlash('success', 'Form sent');
            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
