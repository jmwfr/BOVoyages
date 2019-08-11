<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Reservation;
use App\Entity\Voyage;
use App\Entity\Voyageur;
use App\Repository\ClientRepository;
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
                'choice_label' => function($voyage) {
                    return $voyage->getDestinationCountry()." (".$voyage->getDestinationCity().")";
                },
                'choice_value' => "id",
                'query_builder' => function(VoyageRepository $repo) {
                    return $repo->getAlldBuilder();
                }
            ])
            ->add('clients', EntityType::class, [
                'label' => 'Client',
                'class' => Client::class,
                'choice_label' => "clientFullName",
                'choice_value' => "id",
                'query_builder' => function(ClientRepository $repo){
                    return $repo->getBuilderAll();
                },
                'mapped' => false,
                'required' => false,
                'placeholder' => "Sélectionnez un client"
            ])
            ->add('client', ClientType::class, [
                'label' => false,
                'attr' => ['style' => 'display:none' ],
                'required' => false
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
                'mapped' => true
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
