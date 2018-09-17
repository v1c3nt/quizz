<?php

namespace App\Form;

use App\Entity\Quizz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('level')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quizz::class,
        ]);
    }
}