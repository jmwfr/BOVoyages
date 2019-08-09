<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Voyage;
use App\Entity\Voyageur;
use App\Repository\VoyageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voyage', EntityType::class, [
                'class' => Voyage::class,
                'choice_label' => "destinationVoyage",
                'choice_value' => "id",
                'query_builder' => function(VoyageRepository $repo) {
                    return $repo->getNotReservedBuilder();
                }
            ])
            ->add('client', ClientType::class, [
                'label' => false
            ])
            ->add('numCB', TextType::class, [
                'label' => 'Numéro de Carte Bleue'
            ])
            ->add('voyageurs', CollectionType::class, [
                'entry_options' => ['label' => false],
                'entry_type' => VoyageurType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
