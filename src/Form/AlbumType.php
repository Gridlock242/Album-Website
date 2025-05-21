<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Band;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'album',
                'attr' => ['placeholder' => 'Entrez le titre de l\'album']
            ])
            ->add('releaseDate', DateType::class, [
                'label' => 'Date de sortie',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker'],
                'years' => range(date('Y'), 1950)
            ])
            ->add('image', TextType::class, [
                'label' => 'URL de l\'image',
                'attr' => ['placeholder' => 'Entrez l\'URL de l\'image']
            ])
            ->add('band', EntityType::class, [
                'class' => Band::class,
                'choice_label' => 'name', // Utilise le nom du groupe au lieu de l'ID
                'label' => 'Artiste',
                'placeholder' => 'Sélectionnez un artiste'
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name', // Utilise le nom du genre au lieu de l'ID
                'multiple' => true,
                'expanded' => false,
                'label' => 'Genres',
                'attr' => ['class' => 'select2'] // Pour utiliser select2 si disponible
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
