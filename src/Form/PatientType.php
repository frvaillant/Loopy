<?php

namespace App\Form;

use App\Entity\Patient;
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
                'attr'  => ['placeholder' => 'Nom', 'title'=> 'Ajoutez un nom']
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Prénom', 'title'=> 'Ajoutez un prénom']
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => false,
                'widget' => 'single_text',
                'attr'=>['title'=>'ex : 02/12/2019']
            ])
            ->add('weight', IntegerType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Poids (kg)', 'title'=> 'ex : 20']
            ])
            ->add('limitUp', IntegerType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Seuil haut (mg/dL)', 'title'=> 'ex : 180']
            ])
            ->add('limitDown', IntegerType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Seuil bas (mg/dL)', 'title'=> 'ex : 60']
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'attr'=>['title'=>'votrepatient@exemple.com']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
