<?php

namespace App\Form;

use App\Entity\Master;
use App\Entity\Slave;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', EntityType::class, [
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'class' => Master::class
            ])
            ->add('tool', EntityType::class, [
                'expanded' => false,
                'multiple' => true,
                'required' => false,
                'class' => Slave::class,
                'empty_data' => 'Choisir un ou plusieurs outil(s)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Master::class,
        ]);
    }
}
