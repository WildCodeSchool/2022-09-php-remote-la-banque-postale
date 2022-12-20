<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SignUpType;
use App\Entity\User;

class SignUpController extends AbstractController
{
    #[Route('/signup', name: 'app_sign_up')]
    public function index(): Response
    {
        $user = new User;
        $form = $this->createForm(SignUpType::class, $user);
        return $this->render('sign_up/index.html.twig', [
            'form' => $form,
        ]);
    }
}
