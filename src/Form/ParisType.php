<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ParisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('borough', TextType::class)
            ->add('district', TextType::class)
            ->add('count_hotel', TextType::class)
            ->add('longitude', TextType::class)
            ->add('latitude', TextType::class)
            ->add('Sauvegarder', SubmitType::class, [
                'attr'  => ['class' => 'btn btn-success col-md-4'],
            ]);
        ;
    }
}