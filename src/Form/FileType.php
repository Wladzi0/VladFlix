<?php

namespace App\Form;

use App\Entity\File;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', TextType::class,array(
                'required' => true,
            ))
            ->add('subtitle',ChoiceType::class,array(
                'required' => false,
                    'choices' => [
                        'English' => 'en',
                        'Polish' => 'pl',
                        'French' => 'fr',
                    ],
                'constraints' => [
                    new NotBlank()],
                'multiple' => true,
                'expanded' => true,))
            ->add('audio',ChoiceType::class,array(
                'required' => true,
                'empty_data' => false,
                'constraints' => [
                    new NotBlank()],
                'choices' => [
                    'English' => 'en',
                    'Polish' => 'pl',
                    'French' => 'fr',
                ],
                'multiple' => true,
                'expanded' => true,
            ))
//            ->add('duration',DateIntervalType::class, [
//                'with_years'  => false,
//                'with_months' => false,
//                'with_days'   => false,
//                'with_hours'  => true,
//                'with_minutes'  => true,
//                'with_seconds'  => true,
//                'hours' => range(0, 23),
//                'minutes' => range(0, 59),
//                'seconds' => range(0, 59),
//            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => File::class,
        ]);
    }
}
