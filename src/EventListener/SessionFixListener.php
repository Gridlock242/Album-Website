<?php
// src/EventListener/SessionFixListener.php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SessionFixListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            // Priorité très haute pour s'exécuter avant le SessionListener de Symfony
            KernelEvents::REQUEST => ['onKernelRequest', 9999]
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
    }
}