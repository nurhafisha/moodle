<?php

namespace App\Form;

use App\Entity\NewUe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code_ue', TextType::class, [
                'label' => 'Code UE',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nom_ue', TextType::class, [
                'label' => 'Nom UE',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image_ue', FileType::class, [
                'label' => 'Image UE',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewUe::class,
        ]);
    }
}
