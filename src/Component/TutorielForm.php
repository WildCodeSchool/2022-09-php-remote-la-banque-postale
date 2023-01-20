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

    #[LiveProp(fieldName: 'tutorielField')]
    public ?Tutoriel $tutoriel = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TutorielType::class, $this->tutoriel);
    }

    #[LiveAction]
    public function addQuestion()
    {
        $this->formValues['questions'] [] = '';
    }

    #[LiveAction]
    public function removeQuestion(#[LiveArg()] int $index)
    {
        unset($this->formValues['questions'] [$index]);
    }
}