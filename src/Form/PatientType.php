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
                'label'=> 'Nom'
            ])
            ->add('firstName', TextType::class, [
                'label'=> 'Prénom'
            ])
            ->add('birthday', BirthdayType::class, [
                'widget'=> 'single_text',
                'label'=>'Date de Naissance',
            ])
            ->add('weight', IntegerType::class, [
                'label'=> 'Poids'
            ])
            ->add('limitUp', IntegerType::class, [
                'label'=>'Seuil haut'
            ])
            ->add('limitDown', IntegerType::class, [
                'label'=>'Seuil bas'
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
