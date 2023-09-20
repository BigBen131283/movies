<?php

namespace App\Form;

use App\Entity\Movies;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('pseudo');
            // ->add('roles')
            
            if($options['is_register_form'])
            {
                $builder->add('password');
            }
            if($options['is_movieslist_form'])
            {
                $builder->add('movies', EntityType::class, [
                    'expanded' => true,
                    'multiple' => true,
                    'required' => false,
                    'class' => Movies::class
                    ])
                    ->remove('password')
                    ->remove('email')
                    ->remove('pseudo');
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_register_form' => true, // par défaut c'est un formulaire d'inscription
            'is_movieslist_form' => false, // par défaut, ce n'est pas un formulaire de création de liste
        ]);
    }
}
