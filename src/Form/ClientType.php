<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomClient', TextType::class, [
                'required' => true,
                'label' => 'Nom Client',
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Nom Client",
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('prenomClient', TextType::class, [
                'required' => true,
                'label' => 'Prénom Client',
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Prénom Client",
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('telClient', TextType::class, [
                'required' => true,
                'label' => 'Téléphone Client',
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Téléphone Client",
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('emailClient', EmailType::class, [
                'required' => true,
                'label' => 'E-mail Client',
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "E-mail Client",
                    "class" => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
