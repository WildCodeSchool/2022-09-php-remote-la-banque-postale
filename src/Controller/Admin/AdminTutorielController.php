<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Tutoriel;

use App\Form\TutorielType;
use App\Repository\LevelRepository;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\TutorielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tutoriel')]
#[IsGranted('ROLE_ADMIN')]
class AdminTutorielController extends AbstractController
{
    #[Route('/', name: 'app_tutoriel_index', methods: ['GET'])]
    public function index(TutorielRepository $tutorielRepository, LevelRepository $levelRepository): Response
    {
        return $this->render('tutoriel/admintutoriel/index.html.twig', [
            'tutoriels' => $tutorielRepository->findAll(),
            'levels' => $levelRepository->findAll()
        ]);
    }


    #[Route('/new', name: 'app_tutoriel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TutorielRepository $tutorielRepository, SluggerInterface $slugger): Response
    {
        $tutoriel = new Tutoriel();
        $form = $this->createForm(TutorielType::class, $tutoriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tutoriel->setSlug($slugger->slug($tutoriel->getTitle()));
            $tutorielRepository->save($tutoriel, true);

            return $this->redirectToRoute('app_tutoriel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tutoriel/admintutoriel/new.html.twig', [
            'tutoriel' => $tutoriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tutoriel_show', methods: ['GET'])]
    public function show(Tutoriel $tutoriel): Response
    {
        return $this->render('tutoriel/admintutoriel/show.html.twig', [
            'tutoriel' => $tutoriel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tutoriel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tutoriel $tutoriel, TutorielRepository $tutorielRepository, EntityManagerInterface $entityManager): Response
    {

        // $answer = new Answer;
        $question = new Question;
        $answersCollection = new ArrayCollection();
        foreach ($question->getAnswers() as $answer) {
            $answersCollection->add($answer);
        }

        $form = $this->createForm(TutorielType::class, $tutoriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($answersCollection as $answer) {
                if (false === $question->getAnswers()->contains($answer)) {
                    // remove the Task from the Tag
                    $answer->setQuestion(null);
                    $entityManager->remove($answer);
                }
            }

                $tutorielRepository->save($tutoriel, true);

                return $this->redirectToRoute('app_tutoriel_index', [], Response::HTTP_SEE_OTHER);
            
            }
            
            return $this->renderForm('tutoriel/admintutoriel/edit.html.twig', [
                'tutoriel' => $tutoriel,
                'form' => $form,
            ]);
        
    }

    #[Route('/{id}', name: 'app_tutoriel_delete', methods: ['POST'])]
    public function delete(Request $request, Tutoriel $tutoriel, TutorielRepository $tutorielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tutoriel->getId(), $request->request->get('_token'))) {
            $tutorielRepository->remove($tutoriel, true);
        }

        return $this->redirectToRoute('app_tutoriel_index', [], Response::HTTP_SEE_OTHER);
    }
}
