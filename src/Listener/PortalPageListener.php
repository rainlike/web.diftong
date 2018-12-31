<?php
/**
 * PortalPage Listener
 * Listens request for portal pages
 *
 * @package App\Controller
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\Routing\RouterInterface as Router;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/** Class PortalPageListener */
class PortalPageListener implements EventSubscriberInterface
{
    /** @var Router */
    protected $router;

    /**
     * PortalPageListener constructor
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * List of subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest')),
        );
    }

    /**
     * Handle kernel request event
     *
     * @param GetResponseEvent $event
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if ($event->getRequest()->get('_route') === 'portal_show') {
            $requestedPath = $event->getRequest()->getPathInfo();
            $availableRoutes = $this->router->getRouteCollection()->all();

            foreach ($availableRoutes as $name => $availableRoute) {
                if ($availableRoute->getPath() === $requestedPath
                    || $availableRoute->getPath() === $requestedPath.'/'
                ) {
                    $routeNameArr = \explode('__', $name);
                    $routeName = (\end($routeNameArr));

                    $event->getRequest()->attributes->set('_controller', $availableRoute->getDefaults()['_controller']);
                    $event->getRequest()->attributes->set('_route', $routeName);
                }
            }
        }
    }
}
