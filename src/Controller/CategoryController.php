<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\Question;
use App\Entity\Tutoriel;
use App\Form\CommentType;
use App\Entity\GameAnswer;
use App\Form\QuestionType;
use App\Repository\GameRepository;
use App\Repository\LevelRepository;
use App\Repository\AnswerRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\TutorielRepository;
use App\Repository\GameAnswerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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

    #[Route('/{slug}/', name: 'category_level_show')]
    public function showLevel(
        string $slug,
        Category $category,
        TutorielRepository $tutorielRepository,
        LevelRepository $levelRepository,
        GameRepository $gameRepository,
        GameAnswerRepository $gameAnswerRepository,
    ): Response {

        if (!$category instanceof Category) {
            throw $this->createNotFoundException(
                'Pas de catégorie nommée : ' . $slug . ' found in category\'s table.'
            );
        }

        $tutoriel = $tutorielRepository->findBy(array('category' => $category));
        $level = $levelRepository->findAll();
        $games = $gameRepository->findBy(array('user' => $this->getUser(), 'tutoriel' => $tutoriel));
        $gameAnswer = $gameAnswerRepository->findBy(array('game' => $games));
        return $this->render('category/level.html.twig', [
            'category' => $category,
            'tutoriels' => $tutoriel,
            'levels' => $level,
            'games' => $games,
            'gameAnswers' => $gameAnswer,
        ]);
    }

    #[Route('/{category_slug}/tutoriel/{tutoriel_slug}', name: 'level_tutoriel_show')]
    #[Entity('category', options: ['mapping' => ['category_slug' => 'slug']])]
    #[Entity('tutoriel', options: ['mapping' => ['tutoriel_slug' => 'slug']])]
    public function showTutoriel(
        Request $request,
        Category $category,
        Tutoriel $tutoriel,
        CommentRepository $commentRepository,
        Question $question,
        AnswerRepository $answerRepository,
        GameRepository $gameRepository,
        GameAnswerRepository $gameAnswerRepository,
    ): Response {

        //Gestion du quizz
        $answerId = $request->get('answer');
        if ($answerId) {
            $game = $gameRepository->findOneBy(['tutoriel' => $tutoriel, 'user' => $this->getUser()]);
            if (!$game) {
                /**
                 * @var User $user
                 */
                $user = $this->getUser();
                $game = new Game();
                $game->setUser($user);
                $game->setTutoriel($tutoriel);
                $gameRepository->save($game, true);
            }

            $gameAnswer = $gameAnswerRepository->findOneBy(['game' => $game, 'question' => $question]);
            if (!$gameAnswer) {
                $gameAnswer = new GameAnswer();
                $gameAnswer->setGame($game);
                $gameAnswer->setQuestion($question);
            }
            $answer = $answerRepository->find($answerId);
            if ($answer->isIscorrect()) {
                //isValidated, puis logo 'check' apparait (route level)
                $this->addFlash('success', 'C\'est la bonne réponse !');
            } else {
                $this->addFlash('danger', 'Mauvaise réponse ! Relisez bien le tutoriel ! ');
            }
            $gameAnswer->setAnswer($answer);
            $gameAnswerRepository->save($gameAnswer, true);
        }

        //Création et validation du formulaire des commentaires
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setTutoriel($tutoriel);
            $commentRepository->save($comment, true);
            $this->addFlash('success', 'Votre commentaire a été publié');
            return $this->redirectToRoute('level_tutoriel_show', [
                'category_slug' => $category->getSlug(),
                'tutoriel_slug' => $tutoriel->getSlug()
            ], Response::HTTP_SEE_OTHER);
        }
        $game = $gameRepository->findOneBy(['tutoriel' => $tutoriel, 'user' => $this->getUser()]);
        $gameAnswer = $gameAnswerRepository->findOneBy(['game' => $game, 'question' => $question]);

        return $this->render('category/tutoriel.html.twig', [
            'category' => $category,
            'tutoriel' => $tutoriel,
            'formComment' => $formComment->createView(),
            'gameAnswers' => $gameAnswer

        ]);
    }
}
