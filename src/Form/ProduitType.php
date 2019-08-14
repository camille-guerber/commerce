<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Produit;
use App\Entity\Voiture;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                "label" => "Titre de l'annonce",
                'attr' => [
                    'autocomplete' => 'off',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'autocomplete' => 'off',
                    'maxlength' => 10000,
                ],
            ])
            ->add('prix', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Prix',
            ])
            ->add('voiture', VoitureType::class)
            ->add('carmarque', EntityType::class, [
                'mapped' => false,
                'label' => 'Marque',
                'class' => Marque::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'choice_value' => 'id',
                'placeholder' => '',
            ])
            ->add('carmodele', EntityType::class, [
                'mapped' => false,
                'label' => 'Modele',
                'class' => Modele::class,
                'choices' => [],
                'disabled' => true,
                'choice_label' => 'nom',
                'choice_value' => 'id',
            ])
            ->add('carmodeleid', HiddenType::class, [
                'mapped' => false,
                'label' => false,
            ])
            ->add('imageOne', ImageType::class, [
                'label' => 'Insérer la 1ère image',
            ])
            ->add('imageTwo', ImageType::class, [
                'label' => 'Insérer la 2nde image',
            ])
            ->add('imageThree', ImageType::class, [
                'label' => 'Insérer la 3ème image',
            ])
            ->add('mapLat', NumberType::class, [
                'attr' => [
                    'class' => "d-none",
                ],
                'label' => false,
            ])
            ->add('mapLong', NumberType::class, [
                'attr' => [
                    'class' => "d-none",
                ],
                'label' => false,
            ])
            ->add('localisation', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'd-none',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Ajouter l'annonce",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
