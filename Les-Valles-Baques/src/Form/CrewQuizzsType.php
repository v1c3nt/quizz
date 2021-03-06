<?php

namespace App\Form;

use App\Form\QuizzType;
use App\Entity\CrewQuizzs;
use App\Form\CrewQuizzsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrewQuizzsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quizz')
            ->add('crew')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CrewQuizzs::class,
        ]);
    }
}
