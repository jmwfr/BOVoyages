<?php

namespace App\Form;

use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Illustration'
            ])
            ->add('destinationCountry')
            ->add('destinationCity')
            ->add('dateAller', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('dateRetour', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('nombrePersonnes')
            ->add('prixVoyage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
