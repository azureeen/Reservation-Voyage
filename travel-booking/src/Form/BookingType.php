<?php

// src/Form/BookingType.php
namespace App\Form;

use App\Entity\Booking;
use App\Entity\Travel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class BookingType extends AbstractType
{

    // Assume that you are handling everything in the controller, so no fields are added here
    // You might want to keep the CSRF token, though

//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('travel', EntityType::class, [
//                'class' => Travel::class,
//                'choice_label' => 'destination',
//                'constraints' => [
//                    new Assert\NotNull(message:"Please select a travel destination.")
//                ]
//            ])
//            ->add('bookingDate', DateType::class, [
//                'constraints' => [
//                    new Assert\NotBlank(message:"Booking date cannot be empty."),
//                    new Assert\Type("\DateTimeInterface", message:"Invalid date format.")
//                ]
//            ])
//            ->add('status', ChoiceType::class, [
//                'choices' => [
//                    'Pending' => 'pending',
//                    'Confirmed' => 'confirmed',
//                    'Cancelled' => 'cancelled'
//                ],
//                'constraints' => [
//                    new Assert\Choice(["pending", "confirmed", "cancelled"], message:"Select a valid status.")
//                ]
//            ]);
//    }
//
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => Booking::class,
//        ]);
//    }
}
