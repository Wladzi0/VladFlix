<?php

namespace App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocalSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;
    public function __construct(string $defaultLocale="en")
    {
        $this->defaultLocale=$defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if(!$request->hasPreviousSession()){
            return;
    }
        if($locale= $request->attributes->get('interfaceLanguage')){
            $request->getSession()->set('_locale',$locale);
        }
        else{
            $request->setLocale($request->getSession()->get('_locale',$this->defaultLocale));
        }
    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST=>[['onKernelRequest',17]]
        ];
    }
}