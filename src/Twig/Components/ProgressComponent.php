<?php

namespace App\Twig\Components;

use App\Entity\Category;
use App\Entity\Level;
use App\Repository\GameAnswerRepository;
use App\Repository\TutorielRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Entity\User;

#[AsTwigComponent('progress')]
class ProgressComponent
{
    public Level $level;
    public Category $category;

    public function __construct(
        private TutorielRepository $tutorielRepository,
        private Security $security,
        private GameAnswerRepository $gameAnswerRepository
    ) {
    }


    public function getGoodQuizz(): null|int
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $result = 0;
        $tutoriels = $this->getTutoriels();
        foreach ($tutoriels as $tutoriel) {
            $questions = $tutoriel->getQuestions();
            foreach ($questions as $question) {
                $correctAnswers =
                    $this->gameAnswerRepository->findCorrectAnswersByUser($user, $question);
                if ($correctAnswers) {
                    $result += count($correctAnswers);
                }
            }
        }

        return $result;
    }

    public function getTotalQuizz(): null|int
    {
        $tutoriels = $this->getTutoriels();
        $totalQuizz = 0;
        foreach ($tutoriels as $tutoriel) {
            $totalQuizz += count($tutoriel->getQuestions());
        }
        return $totalQuizz;
    }

    private function getTutoriels(): array
    {
        return $this->tutorielRepository->findBy(array('level' => $this->level, 'category' => $this->category));
    }
}
