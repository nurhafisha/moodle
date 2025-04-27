<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\UE;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titrePost')
            ->add('typePost')
            ->add('datetimePost', null, [
                'widget' => 'single_text',
            ])
            ->add('descriptionPost')
            ->add('depotPostBlob', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('epingleur', EntityType::class, [
                'class' => User::class,
                'required' => false,
            ])
            ->add('typeMessage')
            ->add('codeUE', EntityType::class, [
                'class' => UE::class,
                'choice_label' => 'code_ue',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
