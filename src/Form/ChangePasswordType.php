<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'disabled'=>true,
                'label'=>'Mon Adresse Email'
            ])
            ->add('firstname', TextType::class,[
                'disabled'=> true,
                'label'=>'Mon Prénom'
            ])
            ->add('lastname', TextType::class,[
                'disabled'=> true,
                'label'=>'Mon Nom'
            ])
            ->add('old_password', PasswordType::class,[
                'mapped' => false, 
                'label' => 'Mon Mot de Passe Actuel',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class,[
                'mapped'=>false,
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques', 
                'label' => 'Mon Nouveau Mot De Passe',
                'required' => true, 
                'first_options' => [ 'label' => 'Nouveau Mot de passe',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nouveau mot de passe'
                ]
            ], 
                'second_options' => [ 'label' => 'Confirmez votre nouveau mot de passe',
                'attr' => [
                    'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                ]
            ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Modifier mon mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
