<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Searchkmmax;
use App\Entity\Searchkmmin;
use App\Entity\Searchprixmax;
use App\Entity\Searchprixmin;
use App\Entity\Searchyearmax;
use App\Entity\Searchyearmin;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kmMin', EntityType::class, [
                'class' => Searchkmmin::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('k')
                        ->orderBy('k.km', 'ASC');
                },
                'choice_label' => 'km',
                'choice_value' => 'km',
                'placeholder' => 'Kilomètres min',
                'label' => 'Kilomètres min',
                'required' => false,
            ])
            ->add('kmMax', EntityType::class, [
                'class' => Searchkmmax::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('k')
                        ->orderBy('k.km', 'ASC');
                },
                'choice_label' => 'km',
                'choice_value' => 'km',
                'placeholder' => 'Kilomètres max',
                'label' => 'Kilomètres max',
                'required' => false,
            ])
            ->add('prixMin', EntityType::class, [
                'class' => Searchprixmin::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.prix', 'ASC');
                },
                'choice_label' => 'prix',
                'choice_value' => 'prix',
                'placeholder' => 'Prix min',
                'label' => 'Prix min',
                'required' => false,
            ])
            ->add('prixMax', EntityType::class, [
                'class' => Searchprixmax::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.prix', 'ASC');
                },
                'choice_label' => 'prix',
                'choice_value' => 'prix',
                'placeholder' => 'Prix max',
                'label' => 'Prix max',
                'required' => false,
            ])
            ->add('minYear', EntityType::class, [
                'class' => Searchyearmin::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('y')
                        ->orderBy('y.year', 'ASC');
                },
                'choice_label' => 'year',
                'choice_value' => 'year',
                'placeholder' => 'Année min',
                'label' => 'Année min',
                'required' => false,
            ])
            ->add('maxYear', EntityType::class, [
                'class' => Searchyearmax::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('y')
                        ->orderBy('y.year', 'ASC');
                },
                'choice_label' => 'year',
                'choice_value' => 'year',
                'placeholder' => 'Année max',
                'label' => 'Année max',
                'required' => false,
            ])
            ->add('sort', ChoiceType::class, [
                'choices' => [
                    'Les plus récentes' => 'DESC_pub',
                    'Les plus anciennes' => 'ASC_pub',
                    'Prix croissant' => 'ASC_prix',
                    'Prix décroissant' => 'DESC_prix',
                ],
                'label' => 'Trier par',
            ])
            ->add('carmarque', EntityType::class, [
                'label' => 'Marque',
                'class' => Marque::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'choice_value' => 'id',
                'placeholder' => '',
                'required' => false,
            ])
            ->add('carmodele', EntityType::class, [
                'label' => 'Modele',
                'class' => Modele::class,
                'choices' => [],
                'disabled' => true,
                'choice_label' => 'nom',
                'choice_value' => 'id',
                'placeholder' => '',
                'required' => false,
            ])
            ->add('carmodeleid', HiddenType::class, [
                'mapped' => false,
                'label' => false,
                'required' => false,
            ])
            ->add('location', HiddenType::class, [
                'required' => false,
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Rechercher',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
