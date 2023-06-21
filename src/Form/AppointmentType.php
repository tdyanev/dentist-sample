<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
                'invalid_message' => 'Date should be in this format: "yyyy-MM-dd HH:mm"',

                // adds a class that can be selected in JavaScript
                //'attr' => ['class' => 'js-datepicker'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
