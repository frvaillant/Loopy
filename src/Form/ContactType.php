<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'col-8 offset-1'],
                'label_attr' => ['class' => 'col-2 text-center font-weight-bold']
            ])
            ->add('dadSurname', TextType::class, [
                'label' => 'Nom de famille',
                'label_attr' => ['class' => 'font-weight-bold']
            ])
            ->add('dadFirstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'mt-3'],
                'label_attr' => ['class' => 'mt-3 font-weight-bold']
            ])
            ->add('dadPhoneNumber', NumberType::class, [
                'label' => 'N° de téléphone',
                'attr' => ['class' => 'mt-3'],
                'label_attr' => ['class' => 'mt-3 font-weight-bold']
            ])
            ->add('momSurname', TextType::class, [
                'label' => 'Nom de famille',
                'label_attr' => ['class' => 'font-weight-bold']
            ])
            ->add('momFirstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'mt-3'],
                'label_attr' => ['class' => 'mt-3 font-weight-bold']
            ])
            ->add('momPhoneNumber', NumberType::class, [
                'label' => 'N° de téléphone',
                'attr' => ['class' => 'mt-3'],
                'label_attr' => ['class' => 'mt-3 font-weight-bold']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
