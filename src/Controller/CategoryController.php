<?php

namespace App\Controller;

use App\Entity\Level;
use App\Entity\Category;
use App\Entity\Tutoriel;
use App\Form\CategoryType;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\CategoryRepository;
use App\Repository\LevelRepository;
use App\Repository\TutorielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{categoryId}/', methods: ['GET'], name: 'category_tutoriel_show')]
    public function show(
        int $categoryId,
        CategoryRepository $categoryRepository,
        TutorielRepository $tutorielRepository,
        LevelRepository $levelRepository
    ): Response {
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with id : ' . $categoryId . ' found in program\'s table.'
            );
        }
        $tutoriel = $tutorielRepository->findBy(array('category' => $category));
        $level = $levelRepository->findAll();

        return $this->render('category/tutoriel.html.twig', [
            'categories' => $category,
            'tutoriels' => $tutoriel,
            'levels' => $level,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
