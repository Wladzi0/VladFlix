<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['constraints' => [
        new Length([
            'min' => 2,
        ]),],])
            ->add('lastName', TextType::class, ['constraints' => [
        new Length([
            'min' => 2,
        ]),],])
            ->add('email', EmailType::class)
            ->add('defaultLanguage', LanguageType::class, [
                'placeholder' => false,
                'required' => true,
            ])
            ->add('pin', PasswordType::class, [
                'required' => true,
                'label'=>'PIN code (4 digits)',
                'attr' => ['autocomplete' => 'off'],
                'constraints' => [
                    new Regex(array(
                            'pattern' => '/^[0-9]\d*$/',
                            'message' => 'Please use only positive numbers.'
                        )
                    ),
                    new Length([
                        'min' => 4,
                        'max' => 4,
                        'exactMessage' => 'The pin value should have exactly 4 digits.'
                    ]),],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'The password value should have at least 6 characters.'
                    ]),],
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                'mapped' => false,
                'required' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
