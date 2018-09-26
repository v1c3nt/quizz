<?php

namespace App\Form;

use App\Entity\Crew;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NewCrewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('description')
            ->add('isPrivate', ChoiceType::class, [
                'label' => 'recrutement',
                'choices' => [
                    'privé' => 1,
                    'public'=> 0,
                ],
                'expanded' => true,
                'help' => 'privé = Tu seras obligé d\'inviter tous les nouveaux membres - ouvert = toutes personnes peut s\'ajouter à ton groupe'
            ])
            ->add('avatar', null, [
                'required' => false,
                'help' => 'Si tu es pressé(e), pas de souci tu pourras l\'ajouter plus tard dans ton profil'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Crew::class,
        ]);
    }
}