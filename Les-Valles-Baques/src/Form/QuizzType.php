<?php

namespace App\Form;

use App\Entity\Quizz;
use App\Entity\CrewQuizzs;
use App\Form\QuestionType;
use App\Form\CrewQuizzsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label'=>'Titre du Quizz'
            ])
            ->add('description', null, [
                'required'=> false,
            ])
            
            ->add('category', null, [
                'label'=>'Catégorie'
            ])
            //? on pourrait le calculé a partir des difficultés des questions ?
            ->add('level')
            
       
            //->add('questions', QuestionType::class)
            ->setAttributes([
            'novalidate'=>'novalidate',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}
