<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez-vous donner à votre adresse?',
                'attr' => [
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstname',  TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Renseignez votre prénom'
                ]
            ])
            ->add('lastname',  TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Renseignez votre nom'
                ]
            ])
            ->add('company',  TextType::class, [
                'label' => 'Votre société (Facultatif)',
                'required' => false, 
                'attr' => [
                    'placeholder' => 'Renseignez votre société'
                ]
            ])
            ->add('address',  TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => '22 impasse Georges Brassens ...'
                ]
            ])
            ->add('postal',  TextType::class, [
                'label' => 'Votre code postal',
                'attr' => [
                    'placeholder' => 'Renseignez votre code postal'
                ]
            ])
            ->add('city',  TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('phone',  TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
