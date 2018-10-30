<?php
declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;

use Gedmo\Exception\InvalidArgumentException;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Class DoctrineExtensionListener
 *
 * @package App\Listener
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class DoctrineExtensionListener implements ContainerAwareInterface
{
    /** @var Container */
    protected $container;

    /**
     * Set Container
     *
     * @param Container|null $container
     * @return void
     */
    public function setContainer(?Container $container = null): void
    {
        $this->container = $container;
    }

    /**
     * Late Kernel Request
     *
     * @param GetResponseEvent $event
     * @return void
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     */
    public function onLateKernelRequest(GetResponseEvent $event): void
    {
        $translatable = $this->container->get('gedmo.listener.translatable');
        $translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }

    /**
     * Console Command
     *
     * @return void
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     */
    public function onConsoleCommand(): void
    {
        $this->container->get('gedmo.listener.translatable')
            ->setTranslatableLocale($this->container->get('translator')->getLocale());
    }

    /**
     * Kernel Request
     *
     * @param GetResponseEvent $event
     * @return void
     * @throws InvalidArgumentException
     * @throws ServiceNotFoundException
     * @throws ServiceCircularReferenceException
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $securityContext = $this->container->get('security.context', Container::NULL_ON_INVALID_REFERENCE);

        if (null !== $securityContext
            && null !== $securityContext->getToken()
            && $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')
        ) {
            $loggable = $this->container->get('gedmo.listener.loggable');
            $loggable->setUsername($securityContext->getToken()->getUsername());
        }
    }
}
