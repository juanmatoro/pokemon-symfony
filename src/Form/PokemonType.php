<?php

namespace App\Form;

use App\Entity\Debilidad;
use App\Entity\Pokemon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null,
                [
                    'label' =>'Nombre',
                    'attr' => [
                        'placeholder' => 'Introduce el nombre del Pokemon'
                    ]
                ]
            )
            ->add('description')
            ->add('imageFile', FileType::class, [
                'mapped' => false
            ])
            ->add('code')
            ->add('debilidades', EntityType::class, [
                'class' => Debilidad::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'style' => 'display: flex'
                ]
            ])
        ->add("Enviar", SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
