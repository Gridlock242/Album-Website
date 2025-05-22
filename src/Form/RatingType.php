<?php

namespace App\Form;

use App\Entity\Rating;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', ChoiceType::class, [
                'choices' => [
                    '⭐️' => 1,
                    '⭐️⭐️' => 2,
                    '⭐️⭐️⭐️' => 3,
                    '⭐️⭐️⭐️⭐️' => 4,
                    '⭐️⭐️⭐️⭐️⭐️' => 5,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Noter',
                'attr' => ['class' => 'ml-2 bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700 text-sm']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}

