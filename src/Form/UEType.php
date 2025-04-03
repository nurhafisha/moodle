<?php

namespace App\Form;

use App\Entity\UE;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeUE', TextType::class, [
                'label' => 'Code UE', // Custom label
                'attr' => ['class' => 'form-control'], // Add custom classes if needed
            ])
            ->add('nomUE', TextType::class, [
                'label' => 'Nom UE', // Custom label
                'attr' => ['class' => 'form-control'],
            ])
            ->add('imageUE', FileType::class, [
                'label' => 'Upload Image',
                'mapped' => false, // Prevent automatic mapping to the entity
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UE::class,
        ]);
    }
}
