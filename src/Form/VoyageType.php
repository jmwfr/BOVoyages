<?php

namespace App\Form;

use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uploadedFile', FileType::class, [
                'label' => 'Illustration',
                'data_class' => null,
                'required' => false,
                'attr' => [
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('destinationCountry', TextType::class, [
                'label' => 'Pays',
                'attr' => [
                    "placeholder" => "Pays",
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('destinationCity', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    "placeholder" => "Ville",
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    "placeholder" => "Description",
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('dateAller', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date Aller',
                'attr' => [
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('dateRetour', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date Retour',
                'attr' => [
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('nombrePersonnes', NumberType::class, [
                'label' => 'Nb. Personnes',
                'attr' => [
                    "placeholder" => "Nb. Personnes",
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('prixVoyage', NumberType::class, [
                'label' => 'Prix',
                'attr' => [
                    "placeholder" => "Prix",
                    "class" => "form-control mb-3"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
