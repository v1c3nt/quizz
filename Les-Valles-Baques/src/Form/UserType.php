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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpKernel\DataCollector\DumpDataCollector;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

                $user = $event->getData();

                $form = $event->getForm();
                Dump($user);
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
                    $form->add('userName', null, [
                        'label' => 'Nom de joueur *',
                        'help' => 'C\'est le seul champs visible par les autres joueurs',
                    ])
                        ->add('email', EmailType::class, [
                            'label' => 'Email *',
                            'help' => 'Ton adressse ne sera pas visible par les autres utilisateurs'
                        ])
                        ->add('password', RepeatedType::class, array(
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
            })
            ->add('avatar', FileType::class, [
                'label' => 'Ton Avatar',
                'required' => false,
                'help' => 'Si tu es pressé(e), pas de souci tu pourras l\'ajouter plus tard dans ton profil'
            ])
            ->add('presentation', null, [
                'required' => false,
                'help' => 'Si tu es pressé(e), pas de souci tu pourras le remplir plus tard dans ton profil'
            ])
            ->setAttributes([
                'novalidate' => 'novalidate',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
