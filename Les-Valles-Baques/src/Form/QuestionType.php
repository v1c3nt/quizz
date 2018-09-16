<?php

namespace App\Form;

use App\Form\QuizzType;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quizz', EntityType::class, array(
                'class'=> Quizz::class,
                'choice_label'=> 'title',
                'label'=> 'Quizz name',
                'translation_domain' => 'messages',
                'mapped'=>true,))
            ->add('body')
            ->add('prop1')
            ->add('prop2')
            ->add('prop3')
            ->add('prop4')
            ->add('anecdote')
            ->add('source')
            //->add('errore')
            //->add('level')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
