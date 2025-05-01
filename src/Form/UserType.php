<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UE;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nomUser', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('prenomUser', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nouvelle mot de passe',
                'mapped' => false,   // Not mapped to the User entity
                'required' => false, // Optional utk tukar
                'attr' => ['class' => 'form-control'],
            ])


            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'required' => false,
                'choices' => [
                    'Etudiant' => 'ROLE_ETUDIANT',
                    'Prof' => 'ROLE_PROF',
                    'Prof. Admin' => 'ROLE_PROF_ADMIN',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'expanded' => false, // Renders as a dropdown or radio buttons
                'multiple' => false, // Allows only one selection
                'mapped' => false, // Prevent automatic mapping
                'data' => $options['data']->getSingleRole(), // Set the initial value
            ])

            ->add('liste_ue', EntityType::class, [
                'class' => UE::class,
                'choice_label' => 'nomUe', // Display the UE name
                'multiple' => true, // Allow selecting multiple UEs
                'expanded' => true, // Display as checkboxes
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
