<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'app_favoris', methods: ['GET'])]
    public function favoris(): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette route !');
        }
        return $this->render('category/favoris.html.twig');
    }
}
