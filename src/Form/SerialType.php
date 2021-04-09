<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Serial;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class SerialType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'required' => true,
                'label' => $this->translator->trans('Name of serial'),
            ))
            ->add('country', CountryType::class, array(
                'required' => true,
                'label' => $this->translator->trans('Country'),
            ))
            ->add('yearStart', ChoiceType::class, [
                'required' => true,
                'empty_data' => null,
                'preferred_choices' => array(null),
                'label' => $this->translator->trans('Year of production'),
                'choices' => $this->getYears(1950)])
            ->add('yearFinish', ChoiceType::class, [
                'required' => true,
                'label' => $this->translator->trans('Year of finish'),
                'choices' => $this->getYears(1951)])
            ->add('ageCategory', ChoiceType::class, [
                'placeholder' => false,
                'required' => true,
                'choices' => [
                    'Kid (0-13 years)' => null,
                    'Teenager (13-18 years)' => false,
                    'Adult(+18 years)' => true,
                ],])
            ->add('categories', EntityType::class, [
                'required' => true,
                'label' => $this->translator->trans('Categories'),
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
            ]);;
//        $builder->addEventSubscriber(new Subscriber);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serial::class,
        ]);
    }

    private function getYears($min, $max = 'current')
    {
        $years = range($min, ($max === 'current' ? date('Y') : $max));

        return array_combine($years, $years);
    }
}
