<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Saisir une adresse mail',
                'attr' => [
                    'autocomplete' => 'off',
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'Saisir un pseudo',
                'attr' => [
                    'autocomplete' => 'off',
                ],
            ])
//            ->add('profilPic', ImageType::class, [
//                'label' => false,
//                'required' => false,
//            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent correspondre.',
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                ],
                'second_options' => [
                    'label' => 'Saisir à nouveau votre mot de passe',
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de contact',
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
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
