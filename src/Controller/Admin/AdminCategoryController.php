<?php

namespace App\Controller\Admin;

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
#[IsGranted('ROLE_ADMIN')]
class AdminCategoryController extends AbstractController
{
    #[Route('/', name: 'admin_app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/admincategory/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository, SluggerInterface $slugger): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($category->getLabel());
            $category->setSlug($slug);
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/admincategory/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('admin_app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/admincategory/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    #[Route('/{slug}/', name: 'admin_app_category_show')]
    public function show(string $slug, Category $category): Response
    {
        if (!$category instanceof Category) {
            throw $this->createNotFoundException(
                'Pas de catégorie nommée : ' . $slug
            );
        }
        return $this->render('category/admincategory/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }


        return $this->redirectToRoute('admin_app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
