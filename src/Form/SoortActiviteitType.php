<?php

namespace App\Form;

use App\Entity\Soortactiviteit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoortActiviteitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('naam')
            ->add('beschrijving')
            ->add('minLeeftijd')
            ->add('tijdsduur', NumberType::class, ['label' => 'Tijdsduur in min'])
            ->add('prijs')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Soortactiviteit::class,
        ]);
    }
}
