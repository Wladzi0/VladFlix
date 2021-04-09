<?php

namespace App\Form;

use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;

class Subscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents():array
    {
        return[FormEvents::PRE_SET_DATA=>'preSetData'];
    }

    public function preSetData(FormEvent $event, Request $request):void
    {
//        $serial=$event->getData();
//        $form =$event->getForm();
//        $season= new Season();
//        if(!$serial || null === $serial->getId()){
//            $form = $this->createForm(SeasonType::class, $season);
//        }
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            dump($form;
//            die();
//        }
    }
}