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
                'label' => 'Nom de joueur',
                'help' => 'c\'est le seul champs visible par les autres joueur',
            ])
            ->add('email', EmailType::class,[
                'help'=> 'votre adressse ne sera pas visible par les autres Utilisateurs'
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => array(
                    'attr' => array(
                        'class' => 'password-field'
                    )
                ),
                'required' => false,
                'first_options' => array(
                    'label' => 'Password'
                ),
                'second_options' => array(
                    'label' => 'Repeat Password'
                ),
            ))
            ->add('avatar', null ,[
                'required' => false,
                'help' => 'Ce champs peut être modifier dans votre page Profile'
            ])
            ->add('presentation', null, [
                'required' => false,
                'help' => 'Ce champs peut être modifier dans votre page Profile'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
