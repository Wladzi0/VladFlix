<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

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
                    'Adults (+18 years)' => true,
                ],])
        ->add('pin', PasswordType::class,[
        'required' =>false,
        'constraints' => [
            new Length([
                'min' => 4,
                'minMessage' => 'Your pin must contain at least {{ limit }} digits',
                'max' => 4,
                'maxMessage' => 'Your pin must contain no more than {{limit }} digits',
                'exactMessage'=> 'The pin value should have exactly 4 digits.'
            ]),],
    ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}