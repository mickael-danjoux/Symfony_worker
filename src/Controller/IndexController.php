<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Message\LongActionMessage;
use App\Services\ContactService;
use App\Services\LongActionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly ContactService $contactService,
        private readonly LongActionService $longActionService,
        private readonly MessageBusInterface $bus
    ) {
    }

    #[Route('', name: 'app_index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class)->handleRequest($request);
        if ($this->contactService->proceed($form)) {
            $this->addFlash('success', 'Form sent');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/long-action', name: 'app_long_action')]
    public function longAction(): RedirectResponse
    {
        $this->longActionService->proceed();
        $this->addFlash('success', 'Result sent by email.');
        return $this->redirectToRoute('app_index');
    }

    #[Route('/long-action-async', name: 'app_long_action_async')]
    public function longActionAsync(
        #[MapQueryParameter] bool $error = false
    ): RedirectResponse
    {
        $this->bus->dispatch(new LongActionMessage($error));
        $this->addFlash('success', 'Result will be send by email.');
        return $this->redirectToRoute('app_index');
    }

}
