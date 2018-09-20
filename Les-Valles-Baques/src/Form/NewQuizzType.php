<?php

namespace App\Form;

use App\Entity\Quizz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewQuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('description')
            ->add('IsPrivate', null, [
                'label'=>'Privé',
                'help'=>'Si tu coches cette option, le Quizz ne sera visible que dans ton groupe actuel'
            ])
            ->add('category')
            ->add('author')
            ->add('crew')
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
