<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject;

use Seniorcote\RequestObject\Builder\FromJsonBody;
use Seniorcote\RequestObject\Builder\FromQueryParameters;
use Seniorcote\RequestObject\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ControllerArgumentsSubscriber.
 */
final class ControllerArgumentsSubscriber implements EventSubscriberInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var array
     */
    private array $violations = [];

    /**
     * ControllerArgumentsSubscriber constructor.
     *
     * @param ValidatorInterface  $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
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
     * @throws \ReflectionException|ValidationException
     */
    public function onControllerArguments(ControllerArgumentsEvent $event): void
    {
        $objects = [];

        foreach ($event->getArguments() as $index => $argument) {
            switch (true) {
                case $argument instanceof RequestObjectFromJson:
                    $builder = new FromJsonBody();
                    $objects[$index] = $builder->build($event->getRequest(), $argument);

                    break;
                case $argument instanceof RequestObjectFromQuery:
                    $builder = new FromQueryParameters();
                    $objects[$index] = $builder->build($event->getRequest(), $argument);

                    break;
            }
        }

        $this->validate($objects);
        $arguments = $event->getArguments();

        foreach ($objects as $index => $object) {
            $arguments[$index] = $object;
        }

        $event->setArguments($arguments);
    }

    /**
     * @param array $objects
     *
     * @throws ValidationException
     */
    private function validate(array $objects): void
    {
        foreach ($objects as $object) {
            $violations = $this->validator->validate($object);

            if ($violations->count() > 0) {
                $this->violations[get_class($object)] = $violations;
            }
        }

        if (count($this->violations) > 0) {
            throw new ValidationException($this->violations);
        }
    }
}