<?php

namespace App\Form;

use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class SeasonType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => $this->translator->trans('Name of season'),
            ])

            ->add('year',ChoiceType::class, [
                'empty_data' => null,
                'required'=>false,
                'preferred_choices' => array(null),
                'label' => $this->translator->trans('Year of production'),
                'choices' => $this->getYears(1950)])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
    private function getYears($min, $max = 'current')
    {
        $years = range($min, ($max === 'current' ? date('Y') : $max));

        return array_combine($years, $years);
    }
}
