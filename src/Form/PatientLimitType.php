<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientLimitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('weight', IntegerType::class, [
                'label'=> 'Poids (kg)',
                'attr' => ['class' => 'col-5'],
                'label_attr' => ['class' => 'col-6']
            ])
            ->add('limitUp', IntegerType::class, [
                'label'=>'Seuil haut (mg/dL)',
                'attr' => ['class' => 'col-5'],
                'label_attr' => ['class' => 'col-6']
            ])
            ->add('limitDown', IntegerType::class, [
                'label'=>'Seuil bas (mg/dL)',
                'attr' => ['class' => 'col-5'],
                'label_attr' => ['class' => 'col-6']

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
