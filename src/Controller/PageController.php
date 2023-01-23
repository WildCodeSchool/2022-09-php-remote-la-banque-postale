<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/page', name: 'page_')]
class PageController extends AbstractController
{
    #[Route('/footer', name: 'index')]
    public function index(PageRepository $pageRepository): Response
    {
        $pages = $pageRepository->findAll();
        return $this->render('Include/_footer.html.twig', [
            'pages' => $pages,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Page $page): Response
    {
        return $this->render('page/show.html.twig', [
            'page' => $page,
        ]);
    }
}
