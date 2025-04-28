<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UE;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nomUser', TextType::class, [
                'label' => 'registrationForm.nomUser', // Translation key
                'attr' => ['class' => 'form-control'],
            ])
            ->add('prenomUser', TextType::class, [
                'label' => 'registrationForm.prenomUser', // Translation key
                'attr' => ['class' => 'form-control'],
            ])
            // ->add('email', EmailType::class, [
            //     'label' => 'registrationForm.email', // Translation key
            //     'attr' => ['class' => 'form-control'],
            // ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'registrationForm.password', // Translation key
                'mapped' => false, // Not mapped to the User entity
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
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
                'expanded' => false, // Renders as a dropdown or radio buttons
                'multiple' => false, // Allows only one selection
                'mapped' => false, // Prevent automatic mapping
                'data' => $options['data']->getSingleRole(), // Set the initial value
                'placeholder' => 'Choisissez un rôle',
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
