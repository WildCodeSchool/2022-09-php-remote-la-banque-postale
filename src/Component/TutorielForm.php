<?php

namespace App\Component;

use App\Entity\Tutoriel;
use App\Form\TutorielType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent('tutoriel_form')]
class TutorielForm extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(dehydrateWith: 'dehydrateWith', fieldName: 'tutorielField')]
    public ?Tutoriel $tutoriel = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TutorielType::class, $this->tutoriel);
    }

    public function dehydrateWith(): void
    {
    }

    #[LiveAction]
    public function addQuestion(): void
    {
        $this->formValues['questions'][] = '';
    }

    #[LiveAction]
    public function removeQuestion(#[LiveArg()] int $index): void
    {
        unset($this->formValues['questions'][$index]);
    }

    #[LiveAction]
    public function addAnswer(#[LiveArg()] int $questionIndex): void
    {
        $this->formValues['questions'][$questionIndex]['answers'][] = '';
    }

    #[LiveAction]
    public function removeAnswer(#[LiveArg()] int $questionIndex, #[LiveArg()] int $answerIndex): void
    {
        unset($this->formValues['questions'][$questionIndex]['answers'][$answerIndex]);
    }
}
