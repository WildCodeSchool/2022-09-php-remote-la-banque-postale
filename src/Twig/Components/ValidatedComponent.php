<?php

namespace App\Twig\Components;

use App\Entity\Game;
use App\Entity\Tutoriel;
use App\Repository\GameRepository;
use App\Repository\GameAnswerRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('badge')]
class ValidatedComponent
{
    public Tutoriel $tutoriel;

    public function __construct(
        private GameAnswerRepository $gameAnswerRepository,
        private GameRepository $gameRepository,
        private Security $security
    ) {
    }

    public function getUserAnswer(): ?bool
    {
        $userGame = $this->userHasGame();
        if ($userGame) {
            $questions = $this->tutoriel->getQuestions();
            $question = $questions ? $questions[0] : null;
            $gameAnswer = $this->gameAnswerRepository->findOneBy(['game' => $userGame, 'question' => $question]);
            return $gameAnswer->getAnswer()->isIscorrect();
        }
        return null;
    }

    public function userHasGame(): null|Game
    {
        return $this->gameRepository->findOneBy(['tutoriel' => $this->tutoriel, 'user' => $this->security->getUser()]);
    }
}
