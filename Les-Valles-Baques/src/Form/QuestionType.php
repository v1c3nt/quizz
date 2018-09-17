<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\QuizzType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', TextareaType::class, [
                'label' => 'votre Question',
                'help' => 'soyez pressi'
            ])
            ->add('level', null, [
                'expanded' => true,
            ])
            ->add('prop1', null, [
                'label' => 'bonne réponse'
            ])
            ->add('prop2', null, [
                'label' => 'fause réponse n°1'
            ])
            ->add('prop3', null, [
                'label' => 'fause réponse n°2'
            ])
            ->add('prop4', null, [
                'label' => 'fause réponse n°3'
            ])
            ->add('anecdote', null, [
                'required' => false,
                'help' => 'Une petite sur cette réponse ?'
            ])
            ->add('source', UrlType::class, [
                'required' => false,
                'label' => 'source',
                'help' => 'pensez à mettre un lien vers un article au cas ou on voudrait en savoir plus.'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'attr' => ['id' => 'nextQuestion']
        ]);
    }
}
