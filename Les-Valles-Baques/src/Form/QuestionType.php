<?php

namespace App\Form;

use App\Form\QuizzType;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', TextareaType::class, [
                'label' => 'Ta Question',
                'help' => 'Sois précis '
            ])
            ->add('level', null, [
                'expanded' => true,
            ])
            ->add('prop1', null, [
                'label' => 'Bonne réponse'
            ])
            ->add('prop2', null, [
                'label' => 'Fausse réponse n°1'
            ])
            ->add('prop3', null, [
                'label' => 'Fausse réponse n°2'
            ])
            ->add('prop4', null, [
                'label' => 'Fausse réponse n°3'
            ])
            ->add('anecdote', null, [
                'required' => false,
                'help' => 'Une petite anecdote sur cette réponse ?'
            ])
            ->add('source', UrlType::class, [
                'required' => false,
                'label' => 'Source',
                'help' => 'Pense à mettre un lien vers un article au cas ou on voudrait en savoir plus'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'attr' => ['id' => 'nextQuestion'],
            'method'=> 'POST'
        ]);
    }
}
