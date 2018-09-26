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
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'Email *',
                'help' => 'Ton adressse ne sera pas visible par les autres utilisateurs'
            ])
            ->add('avatar', FileType::class, [
                'label'=>'Le fichier de ton Avatar',
                'required' => false,
                'help' => 'Ajoute ou modifie ton avatar '
            ])
            ->add('presentation', null, [
                'required' => false,
                'help' => 'Si tu l\'as pas déjà fait ajoute un petite description.'
            ])
             ->setAttributes([
            'novalidate'=>'novalidate',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                
                $user = $event->getData();

                $form = $event->getForm();
               
                if ($user->getId()) {
                
                    $form->add('password', RepeatedType::class, array(
                        'type' => PasswordType::class,
                        'invalid_message' => 'Les mots de passe doivent correspondre.',
                        'options' => array(
                            'attr' => array(
                                'class' => 'password-field'
                            )
                        ),
                        'first_options' => array(
                            'label' => 'Password (optionnel)'
                        ),
                        'second_options' => array(
                            'label' => 'Repeat Password'
                        ),
                    ));
                } else { //sinon je suis en creation
                    dump('creation');
                    $form->add('password', RepeatedType::class, array(
                        'type' => PasswordType::class,
                        'constraints' => [
                            new NotBlank(),
                        ],
                        'invalid_message' => 'Les mots de passe doivent correspondre.',
                        'options' => array(
                            'attr' => array(
                                'class' => 'password-field'
                            )
                        ),
                        'first_options' => array(
                            'label' => 'Password (obligatoire)'
                        ),
                        'second_options' => array(
                            'label' => 'Repeat Password'
                        ),
                    ));
                }
            }
        );
    }


}
