<?php

namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Environment;

class PermissionGrantedSubscriber implements EventSubscriberInterface
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private AnnotationReader $annotationReader;
    private Environment $twig;

    public function __construct(
        AuthorizationCheckerInterface $authorizationChecker,
        AnnotationReader $annotationReader,
        Environment $twig
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->annotationReader = $annotationReader;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {

        if (!$event->isMainRequest()) {
            return;
        }

        $excludeRoutes = [
            '_errors',
            '_wdt',
            '_profiler',
            'login',
            'logout'
        ];

        if (in_array($event->getRequest()->attributes->get('_route'), $excludeRoutes)) {
            return;
        }

        [$controller, $method] = $this->getControllerAndMethod($event->getRequest());

        if ($controller === null) {
            throw new \RuntimeException("Controller {$controller} does not exists");
        }

        /** @var IsPermissionGranted $permissionAnnotation */
        $permissionAnnotation = $this->annotationReader->getMethodAnnotation(
            $controller,
            $method,
            IsPermissionGranted::class
        );

        if ($permissionAnnotation === null) {
            $event->stopPropagation();
            $event->setController(function () use($controller, $method) {
                return new Response(
                    $this->twig->render('access-denied.twig', [
                        'resource' => $controller,
                        'access'   => $method,
                    ]),
                    403
                );
            });
            return;
        }

        $resources = $permissionAnnotation->getResource();
        $access = $permissionAnnotation->getAccess();

        if ($this->authorizationChecker->isGranted($access, $resources)) {
            return;
        }

        $event->stopPropagation();
        $event->setController(function () use($controller, $method) {
            return new Response(
                $this->twig->render('access-denied.twig', [
                    'resource' => $controller,
                    'access'   => $method,
                ]),
                403
            );
        });
        return;
    }

    private function getControllerAndMethod(Request $request): ?array
    {
        $controllerWithAction = $request->attributes->get('_controller');

        [$controller, $method] = explode('::', $controllerWithAction);

        if (!class_exists($controller)) {
            return null;
        }

        return [$controller, $method];
    }
}