<?php

namespace App\Form;

use App\Entity\Ask;
use App\Entity\City;
use App\Entity\User;
use App\Entity\Mission;
use App\Entity\Beneficiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('objectif')
            ->add('status')
            ->add('date')
            ->add('city', EntityType::class, [
                // looks for choices from this entity
                'class' => City::class,
                'choice_label' => 'name',
            ])
            ->add('mission', EntityType::class, [
                // looks for choices from this entity
                'class' => Mission::class,
                'choice_label' => 'name',
            ])
            ->add('benificiaire', EntityType::class, [
                // looks for choices from this entity
                'class' => Beneficiaire::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ask::class,
        ]);
    }
}
