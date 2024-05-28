<?php

namespace App\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 

        $builder ->add('places',TypeIntegerType::class, [
            'label'=>'Nbr place',
            'required'=>true,
            'attr'=>['class'=>'form-control mb-3']
        ])
        ->add('destination',TextType::class, [
            'label'=>'Destination',
            'required'=>true,
            'attr'=>['class'=>'form-control mb-3']
        ])
        ->add('checkin',DateTimeType::class, [
            'label'=>'Check-in',
            'widget'=>'single_text',
            'required'=>true,
            'attr'=>['class'=>'form-control mb-3']
        ])
        ->add('checkout',DateTimeType::class, [
            'label'=>'Check-out',
            'widget'=>'single_text',
            'required'=>true,
            'attr'=>['class'=>'form-control mb-3']
        ])
        ->add('contactName',TextType::class, [
            'label'=>'nom et prénom / raison social',
            'required'=>true,
            'attr'=>['class'=>'form-control mb-3']
        ])
        ->add('phone',TextType::class, [
            'label'=>'Télephone',
            'required'=>true,
            'attr'=>['class'=>'form-control mb-3']
        ])
        ->add('email',TextType::class, [
            'label'=>'Email',
            'required'=>true,
            'attr'=>['class'=>'form-control mb-3']
        ])
        

        
        


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
