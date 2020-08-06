<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "autofocus" => null,
                    "placeholder" => "Prénom",
                    "class" => "form-control"
                ],
                'mapped' => false
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Nom",
                    "class" => "form-control"
                ],
                'mapped' => false
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => "Tel.",
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Téléphone",
                    "class" => "form-control"
                ],
                'mapped' => false,
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => "Email",
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "E-mail",
                    "class" => "form-control"
                ],
                'mapped' => false
            ])
            ->add('username', TextType::class, [
                'label' => "Login",
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Login",
                    "class" => "form-control"
                ]
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'label_attr' => ["class" => "sr-only"],
                    'attr' => [
                        "placeholder" => "Mot de passe",
                        "class" => "form-control"
                    ]
                ],
                'second_options' => [
                    'label' => 'Répéter Mdp',
                    'label_attr' => ["class" => "sr-only"],
                    'attr' => [
                        "placeholder" => "Répéter Mdp",
                        "class" => "form-control"
                    ]
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
