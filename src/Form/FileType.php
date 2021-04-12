<?php

namespace App\Form;

use App\Entity\File;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', TextType::class,array(
                'required' => true,
            ))
            ->add('subtitle',ChoiceType::class,array(
                'required' => true,
                    'choices' => [
                        'English' => 'en',
                        'Polish' => 'pl',
                        'French' => 'fr',
                    ],
                'multiple' => true,
                'expanded' => true,))
            ->add('audio',ChoiceType::class,array(
                'required' => true,
                'choices' => [
                    'English' => 'en',
                    'Polish' => 'pl',
                    'French' => 'fr',
                ],
                'multiple' => true,
                'expanded' => true,
            ))
//            ->add('save', SubmitType::class, ['label' => 'Add new film'])
//            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => File::class,
        ]);
    }
}
