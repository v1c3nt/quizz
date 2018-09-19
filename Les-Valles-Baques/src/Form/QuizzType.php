<?php

namespace App\Form;

use App\Entity\Quizz;
use App\Form\QuestionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label'=>'titre'
            ])
            ->add('description')
            ->add('IsPrivate', null, [
                'label' => 'privé',
                'help' => 'Si vous cochez cette option le questionaire ne sera visible que dans votre groupe actuel.'
            ])
            ->add('category', null, [
                'label'=>'catégorie'
            ])
            //? on pourrait le calculé a partir des difficultés des questions ?
<<<<<<< HEAD
            //->add('level')
            //->add('questions')
=======
            ->add('level')
            ->add('questions', QuestionType::class)
>>>>>>> 17b2d5a7706395fab959c947233bd9ef9974120a
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}
