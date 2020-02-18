<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Bundle;

use Doctrine\Common\Annotations\AnnotationException;
use Seniorcote\RequestObject\RequestObject;
use Seniorcote\RequestObject\RequestObjectBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ControllerArgumentsSubscriber.
 */
final class ControllerArgumentsSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestObjectBuilder
     */
    private $requestObjectBuilder;

    /**
     * ControllerArgumentsSubscriber constructor.
     *
     * @param RequestObjectBuilder     $requestObjectBuilder
     */
    public function __construct(RequestObjectBuilder $requestObjectBuilder)
    {
        $this->requestObjectBuilder = $requestObjectBuilder;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => [
                ['onControllerArguments', 0],
            ],
        ];
    }

    /**
     * @param ControllerArgumentsEvent $event
     *
     * @throws \ReflectionException|AnnotationException
     */
    public function onControllerArguments(ControllerArgumentsEvent $event): void
    {
        $requestObjectArgumentIndex = null;

        foreach ($event->getArguments() as $index => $argument) {
            if ($argument instanceof RequestObject) {
                $requestObjectArgumentIndex = $index;

                break;
            }
        }

        if (null === $requestObjectArgumentIndex) {
            return;
        }

        $result = $this->requestObjectBuilder->build(
            $event->getRequest(),
            $event->getArguments()[$requestObjectArgumentIndex]
        );

        if ($result instanceof Response) {
            $event->setController(static function () use ($result) {
                return $result;
            });
        }

        if ($result instanceof RequestObject) {
            $arguments = $event->getArguments();
            $arguments[$requestObjectArgumentIndex] = $result;
            $event->setArguments($arguments);
        }
    }
}