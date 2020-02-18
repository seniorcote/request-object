<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Bundle;

use Seniorcote\RequestObject\Bundle\DependencyInjection\RequestObjectExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class RequestObjectBundle.
 */
final class RequestObjectBundle extends Bundle
{
    /**
     * @return string|ExtensionInterface|null
     */
    public function getContainerExtension()
    {
        return new RequestObjectExtension();
    }
}