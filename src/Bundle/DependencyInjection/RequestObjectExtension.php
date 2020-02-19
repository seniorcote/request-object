<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Bundle\DependencyInjection;

use Seniorcote\RequestObject\Bundle\ControllerArgumentsSubscriber;
use Seniorcote\RequestObject\RequestObjectBuilder;
use Seniorcote\RequestObject\DefaultValidationErrorsResponse;
use Seniorcote\RequestObject\TypeConverter;
use Seniorcote\RequestObject\ValidationErrorsResponse;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

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
        $this->registerControllerArgumentsSubscriber($container);
        $this->registerRequestBuilder($container);
        $this->registerValidationErrorsResponse($container);
        $this->registerTypeConverter($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerControllerArgumentsSubscriber(ContainerBuilder $container): void
    {
        $definition = new Definition(ControllerArgumentsSubscriber::class, [
            new Reference('request_object.request_builder'),
        ]);
        $definition->addTag('kernel.event_subscriber', [
            'event' => 'kernel.controller_arguments',
            'method' => 'onControllerArguments',
        ]);

        $container->setDefinition('request_object.controller_arguments_subscriber', $definition);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerRequestBuilder(ContainerBuilder $container): void
    {
        $definition = new Definition(RequestObjectBuilder::class);
        $definition->setAutowired(true);

        $container->setDefinition('request_object.request_builder', $definition);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerValidationErrorsResponse(ContainerBuilder $container): void
    {
        $definition = new Definition(ValidationErrorsResponse::class);
        $definition->setAbstract(true);

        $container->setDefinition('request_object.validation_errors_response', $definition);

        $implementationDefinition = new ChildDefinition('request_object.validation_errors_response');
        $implementationDefinition->setClass(DefaultValidationErrorsResponse::class);

        $container->setDefinition('request_object.validation_errors_response.default', $implementationDefinition);

        $container->setAlias(ValidationErrorsResponse::class, 'request_object.validation_errors_response.default');
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerTypeConverter(ContainerBuilder $container): void
    {
        $definition = new Definition(TypeConverter::class);

        $container->setDefinition('request_object.type_converter', $definition);
        $container->setAlias(TypeConverter::class, 'request_object.type_converter');
    }
}