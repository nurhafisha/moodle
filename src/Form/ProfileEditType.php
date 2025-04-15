<?php
// src/Form/ProfileEditType.php
namespace App\Form;

use App\Entity\User;
use Dom\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class ProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('nomUser', TextType::class, [
                'label'      => 'Nom',
                'required'   => false,
                'empty_data' => '',
            ])
            ->add('prenomUser', TextType::class, [
                'label'      => 'Prénom',
                'required'   => false,
                'empty_data' => '',
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'required' => false,
                
            ])

            ->add('telephone', TextType::class, [
                'label' => 'Telephone',
                'mapped' => false,
                'required' => false,
                
            ])

            ->add('imageFile', FileType::class, [
                'label' => 'Changer Image',
                'required' => false,
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
            ]);

            }
            public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,  // Bind this form to the User entity
        ]);
    }
        }