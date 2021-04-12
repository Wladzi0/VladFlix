<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Season;
use App\Repository\SeasonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EpisodeType extends AbstractType
{
    private $translator;
    private $seasonRepository;

    public function __construct(TranslatorInterface $translator, SeasonRepository $seasonRepository)
    {
        $this->seasonRepository = $seasonRepository;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $serialId = $options['bySerial'];
        $builder
            ->add('name', TextType::class, array(
                'required' => true,
                'label' => $this->translator->trans('Name of episode'),
            ))
            ->add('year', ChoiceType::class, [
                'empty_data' => null,
                'required' => false,
                'preferred_choices' => array(null),
                'label' => $this->translator->trans('Year of production'),
                'choices' => $this->getYears(1950)])
            ->add('season', EntityType::class, [
                    'required' => true,
                    'class' => Season::class,
                    'choices' => $this->seasonRepository->findBySerial($serialId)

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('bySerial');

        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }

    private function getYears($min, $max = 'current')
    {
        $years = range($min, ($max === 'current' ? date('Y') : $max));

        return array_combine($years, $years);
    }

}
