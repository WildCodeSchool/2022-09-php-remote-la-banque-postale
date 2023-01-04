<?php

namespace App\Form;

use App\Entity\Tutoriel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class TutorielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('level', null, ['choice_label' => 'name'])
            ->add('category', null, ['choice_label' => 'label']
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tutoriel::class,
        ]);
    }
}
