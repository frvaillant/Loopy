<?php

namespace App\Form;

use App\Entity\Doctor;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surname', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Nom']
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Prénom']
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => false,
                'widget' => 'single_text'
            ])
            ->add('weight', IntegerType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Poids (kg)']
            ])
            ->add('limitUp', IntegerType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Seuil haut (mmg/dL)']
            ])
            ->add('limitDown', IntegerType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Seuil bas (mmg/dL)']
            ])
            ->add('email', TextType::class, [
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
