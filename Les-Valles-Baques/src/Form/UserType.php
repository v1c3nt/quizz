<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', null, [
                'label' => 'Nom de joueur *',
                'help' => 'c\'est le seul champs visible par les autres joueurs',
            ])
            ->add('email', EmailType::class, [
                'label' => 'email *',
                'help' => 'votre adressse ne sera pas visible par les autres Utilisateurs'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => array(
                    'attr' => array(
                        'class' => 'password-field'
                    )
                ),
                'first_options' => [
                    'required'=>true,
                    'label' => 'mot de passe *',
                    'help' => '6 caratères dont 1 majuscule, 1 minuscule et un chiffre, c\'est mais c\'est pour toi',
                ],
                'second_options' => [
                    'label' => 'Encore le mot de passe *(c\'est juste pour être sur dsl)',
                ]
            ])
            ->add('avatar', null, [
                'required' => false,
                'help' => 'Si tu es pressé pas de souci tu pourras l\'ajouter dans ton profil plus tard'
            ])
            ->add('presentation', null, [
                'required' => false,
                'help' => 'Si tu es pressé pas de souci tu pourras le remplir dans ton profil plus tard'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
