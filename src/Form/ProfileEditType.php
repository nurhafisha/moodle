<?php
// src/Form/ProfileEditType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
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

            ->add('imageFile', VichImageType::class, [
                'label' => 'Changer Image',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => "Supprimer",
                'download_label' => false,
                'download_uri' => false,
                'image_uri' => false,
            ]);

            }
            public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,  // Bind this form to the User entity
        ]);
    }
        }