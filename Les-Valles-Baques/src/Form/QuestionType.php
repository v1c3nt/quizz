<?php

namespace App\Form;

use App\Form\QuizzType;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quizz', QuizzType::class, [
                'label' => false
            ])
            ->add('body')
            ->add('prop1')
            ->add('prop2')
            ->add('prop3')
            ->add('prop4')
            ->add('anecdote')
            ->add('source')
            ->add('errore')
            ->add('level')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
