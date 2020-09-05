<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Bundle\DependencyInjection;

use Seniorcote\RequestObject\ControllerArgumentsSubscriber;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class RequestObjectExtension.
 */
final class RequestObjectExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $definition = new Definition(ControllerArgumentsSubscriber::class);
        $definition->setAutowired(true);
        $definition->addTag('kernel.event_subscriber', [
            'event' => 'kernel.controller_arguments',
            'method' => 'onControllerArguments',
        ]);

        $container->setDefinition('request_object.controller_arguments_subscriber', $definition);
    }
}