<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', TextType::class, ['required' => true,])
            ->add('age', ChoiceType::class, [
                'placeholder' => false,
                'required' => true,
                'choices' => [
                    'Kid (0-13 years)' => null,
                    'Teenager (13-18 years)' => false,
                    'Adult(+18 years)' => true,
                ],])
            ->add('profilePin', PasswordType::class, [
                'label' => 'PIN',
                'data_class' => null,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Regex(array(
                            'pattern' => '/^[0-9]\d*$/',
                            'message' => 'Please use only positive numbers.'
                        )
                    ),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Your pin must contain at least {{ limit }} digits',
                        'max' => 4,
                        'maxMessage' => 'Your pin must contain no more than {{limit }} digits',
                        'exactMessage' => 'The pin value should have exactly 4 digits.'
                    ]),],
            ])
            ->add('userPin', PasswordType::class, [
                'label' => 'User`s PIN',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Regex(array(
                            'pattern' => '/^[0-9]\d*$/',
                            'message' => 'Please use only positive numbers.'
                        )
                    ),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Your pin must contain at least {{ limit }} digits',
                        'max' => 4,
                        'maxMessage' => 'Your pin must contain no more than {{limit }} digits',
                        'exactMessage' => 'The pin value should have exactly 4 digits.'
                    ]),],
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class
        ]);
    }
}
