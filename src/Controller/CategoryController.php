<?php

namespace App\Controller;

use App\Entity\Level;
use App\Entity\Category;
use App\Entity\Tutoriel;
use App\Form\CategoryType;
use App\Repository\LevelRepository;
use App\Repository\CategoryRepository;
use App\Repository\TutorielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/{slug}/', name: 'category_level_show')]
    public function showLevel(
        string $slug,
        Category $category,
        TutorielRepository $tutorielRepository,
        LevelRepository $levelRepository
    ): Response {

        if (!$category instanceof Category) {
            throw $this->createNotFoundException(
                'Pas de catégorie nommée : ' . $slug . ' found in category\'s table.'
            );
        }

        $tutoriel = $tutorielRepository->findBy(array('category' => $category));
        $level = $levelRepository->findAll();

        return $this->render('category/level.html.twig', [
            'category' => $category,
            'tutoriels' => $tutoriel,
            'levels' => $level,
        ]);
    }

    #[Route('/{category_slug}/tutoriel/{tutoriel_slug}', name: 'level_tutoriel_show')]
    #[Entity('category', options: ['mapping' => ['category_slug' => 'slug']])]
    #[Entity('tutoriel', options: ['mapping' => ['tutoriel_slug' => 'slug']])]
    public function showTutoriel(Category $category, Tutoriel $tutoriel): Response
    {
        return $this->render('category/tutoriel.html.twig', [
            'category' => $category,
            'tutoriel' => $tutoriel,
        ]);
    }
}
