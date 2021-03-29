<?php

namespace App\Subscribers;

use App\Repository\ProfileRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocalSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    private $profileRepository;
    public function __construct(ProfileRepository $profileRepository,string $defaultLocale="en")
    {
        $this->defaultLocale=$defaultLocale;
        $this->profileRepository=$profileRepository;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if(!$request->hasPreviousSession()){
            return;
    }
        if($profileId=$request->getSession()->get('profileId')){

            $profile=$this->profileRepository->find($profileId);
            $request->setLocale($profile->getInterfaceLanguage());
        }
        else{
        if($locale= $request->attributes->get('interfaceLanguage')){
            $request->getSession()->set('_locale',$locale);
        }
        else{
            $request->setLocale($request->getSession()->get('_locale',$this->defaultLocale));
        }
        }
    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST=>[['onKernelRequest',17]]
        ];
    }
}