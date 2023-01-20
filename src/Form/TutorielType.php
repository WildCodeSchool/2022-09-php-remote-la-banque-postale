<?php

namespace App\Form;

use App\Entity\Tutoriel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TutorielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('content', CKEditorType::class)
            ->add('level', null, ['choice_label' => 'name'])
            ->add(
                'category',
                null,
                ['choice_label' => 'label']
            )
            ->add('questions', CollectionType::class, [
                'entry_type' => QuestionType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ]);
                        // ->add('answers', CollectionType::class, [
            //     'entry_type' => AnswerType::class,
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'by_reference' => false
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tutoriel::class,
        ]);
    }
}
