<?php

namespace App\Subscribers;

use App\Repository\ProfileRepository;
use mysql_xdevapi\Session;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocalSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    private $profileRepository;

    private $session;

    public function __construct( SessionInterface $session,ProfileRepository $profileRepository, string $defaultLocale = "en")
    {
        $this->session = $session;
        $this->defaultLocale = $defaultLocale;
        $this->profileRepository = $profileRepository;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }
        if ($profileId = $request->getSession()->get('profileId')) {
            $profile = $this->profileRepository->find($profileId);
            try {
                $request->setLocale($profile->getInterfaceLanguage());
            }
            catch (\Throwable $t){
               $this->session->clear();
            }

        } else {
            if ($locale = $request->attributes->get('interfaceLanguage')) {
                $request->getSession()->set('_locale', $locale);
            } else {
                $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 17]]
        ];
    }
}