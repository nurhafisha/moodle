<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            // ->add('email', EmailType::class, [
            //     'label' => 'Email',
            //     'required' => false,
            //     'attr' => ['class' => 'form-control'],
            // ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'New Password',
                'mapped' => false, // Not mapped to the User entity
                'required' => false, // Optional utk tukar
                'attr' => ['class' => 'form-control'],
            ])


            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'required' => false,
                'choices' => [
                    'Etudiant' => 'ROLE_ETUDIANT',
                    'Prof' => 'ROLE_PROF',
                    'Prof. Admin' => 'ROLE_PROF_ADMIN',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'expanded' => true, // Renders as checkboxes
                'multiple' => true, // Allows multiple selections
            ]);
        // ->add('save', SubmitType::class, [
        //     'label' => 'Save',
        //     'attr' => ['class' => 'btn btn-primary'],
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
