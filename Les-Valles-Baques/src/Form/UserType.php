<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', null, [
                'label' => 'Nom de joueur *',
                'help' => 'C\'est le seul champs visible par les autres joueurs',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'help' => 'Ton adressse ne sera pas visible par les autres utilisateurs'
            ])
            ->add('avatar', null, [
                'data_class' => null,
                'required' => false,
                'help' => 'Si tu es pressé(e), pas de souci tu pourras l\'ajouter plus tard dans ton profil'
            ])
            ->add('presentation', null, [
                'required' => false,
                'help' => 'Si tu es pressé(e), pas de souci tu pourras le remplir plus tard dans ton profil'
            ])
            ->setAttributes([
            'novalidate'=>'novalidate',
            ])

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $user = $event->getData();
                $form = $event->getForm();

                if ($user->getId()) {
                    dump('edition');
                    $form->add(
                        'password',
                        RepeatedType::class,
                        array(
                            'type' => PasswordType::class,
                            'invalid_message' => 'Les mots de passe doivent correspondre.',
                            'options' => array(
                                'attr' => array(
                                    'class' => 'password-field')
                            ),
                            'first_options'  => array(
                                'required' => false,
                                'label' => 'Mot de passe (optionnel)*',
                                'help' => 'Si tu ne veux pas changer de mot de passe, pas besoin de changer'
                            ),
                            'second_options' => array(
                                'required' => false,
                                'label' => 'Encore le mot de passe *(c\'est juste pour être sûr !)'
                            ),
                        )
                    );
                } else { //sinon je suis en creation
                    dump('creation');
                    $form->add(
                        'password',
                        RepeatedType::class,
                        array(
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
                        'first_options'  => array(
                            'label' => 'Mot de passe *',
                            'help' => '6 caratères dont 1 majuscule, 1 minuscule et 1 chiffre, c\'est long mais c\'est pour toi',
                        ),
                        'second_options' => array(
                            'label' => 'Encore le mot de passe *(c\'est juste pour être sûr !)',
                            'help' => 'Les most de passe doivent correspondre',
                        ),
                    )
                );
                }
            });
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
