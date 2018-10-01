<?php

namespace App\Form;

use App\Entity\Crew;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, [
                'class'=> Crew::class,
                'label'=>'Choisir un groupe',
                'help'=>'Si tu as un groupe, tu peux déjà choisir si tu veux le paratger avec les membres groupe',
                'choice_label'=>function ($name) {
                    return $name->getName();
                }
            ])
            //->add('slug')
            //->add('avatar')
            //->add('avatarFile')
            //->add('createdAt')
            //->add('description')
            //->add('isPrivate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Crew::class,
        ]);
    }
}
