<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Entity\Tutoriel;
use App\Repository\UserRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('favori')]
final class FavoriComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?Tutoriel $tutoriel = null;

    public function __construct(private UserRepository $userRepository)
    {
    }

    #[LiveAction]
    public function toggleFav(): void
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->isFavori($this->tutoriel)) {
            $user->removeFavori($this->tutoriel);
        } else {
            $user->addFavori($this->tutoriel);
        }
        $this->userRepository->save($user, true);
    }

    public function isFavori(): bool
    {
        /** @var User $user */
        $user = $this->getUser();
        return $user->isFavori($this->tutoriel);
    }
}
