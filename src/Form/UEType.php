<?php

namespace App\Form;

use App\Entity\UE;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class UEType extends AbstractType
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
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'une image valide est requise (jpeg ou png)',
                    ])
                ],
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
