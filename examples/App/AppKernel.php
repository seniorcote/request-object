<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Examples\App;

use Seniorcote\RequestObject\Bundle\RequestObjectBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class AppKernel.
 */
final class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new RequestObjectBundle(),
        ];
    }

    /**
     * @param LoaderInterface $loader
     *
     * @return void
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir().'/examples/App/config.yaml');
    }
}