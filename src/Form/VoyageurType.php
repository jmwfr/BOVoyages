<?php

namespace App\Form;

use App\Entity\Voyageur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomVoyageur', TextType::class, [
                'label' => 'Nom Voyageur',
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Nom Voyageur",
                    "class" => "form-control my-3"
                ]
            ])
            ->add('prenomVoyageur', TextType::class, [
                'label' => 'Prénom Voyageur',
                'label_attr' => ["class" => "sr-only"],
                'attr' => [
                    "placeholder" => "Prénom Voyageur",
                    "class" => "form-control my-3"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyageur::class,
        ]);
    }
}
