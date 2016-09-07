<?php

namespace Dictionary\ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ParameterBag;


class DomainAwareListener
{

    private $permanentCookie;
    private $setpermanentCookie;


    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->generateIdentifier($event);
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        // If no cookie, then create so we can identify user
        if ( $this->setpermanentCookie ){
            $cookie = new Cookie('dictionary_permanent_cookie', $this->permanentCookie, time() + 3600 * 24 * 365 * 100);
            $response->headers->setCookie($cookie);
        }

    }

    /**
     * Generate Unique user identifier if not set
     * To be used as intern tracking
     * @param GetResponseEvent $event
     */
    private function generateIdentifier(GetResponseEvent $event)
    {
        if ($this->permanentCookie)
            return $this->permanentCookie;

        $request = $event->getRequest();

        /** @var  $cookies ParameterBag */
        $cookies = $request->cookies;

        // Web Cookie
        if ($cookies->has('dictionary_permanent_cookie')) {
            $this->permanentCookie = $cookies->get('dictionary_permanent_cookie');
        }

        if (!$this->permanentCookie) {
            $this->permanentCookie = sha1(microtime() . mt_rand(0, 90000));
            $this->setpermanentCookie = true;
        }
    }
}
