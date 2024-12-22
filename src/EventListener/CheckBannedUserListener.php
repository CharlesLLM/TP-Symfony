<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\RouterInterface;

class CheckBannedUserListener
{
    public function __construct(private Security $security, private RouterInterface $router)
    {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        $user = $this->security->getUser();
        if (null === $user || 'app_banned' === $request->attributes->get('_route')) {
            return;
        }

        if ($this->security->isGranted('ROLE_BANNED')) {
            $event->setController(function () {
                return new RedirectResponse($this->router->generate('app_banned'));
            });
        }
    }
}
