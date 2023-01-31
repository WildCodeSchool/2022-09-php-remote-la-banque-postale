<?php

namespace App\Controller;

use App\Entity\Ticket;
use DateTimeImmutable;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ticket')]
class TicketController extends AbstractController
{
    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketRepository $ticketRepository): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette route !');
        }
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setUser($this->getUser());
            $ticket->setSubmitedAt(new DateTimeImmutable());
            $ticketRepository->save($ticket, true);

            $this->addFlash('success', 'Votre ticket a été envoyé');
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        if ($this->getUser() !== $ticket->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas l\'auteur de ce ticket !');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $ticketRepository->save($ticket, true);
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }
            // ci-dessous, route à changer si on créer un espace user, on redirigera vers
            // une page qui montre au user quels tickets il a rédigé
            return $this->redirectToRoute('app_category_index');
        }

        return $this->renderForm('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ticket->getId(), $request->request->get('_token'))) {
            $ticketRepository->remove($ticket, true);
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
