<?php
declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use RoutesRegistrator\ConfigInterface;
use RoutesRegistrator\HandlersFinder;
use RoutesRegistrator\RouteGenerator;
use RoutesRegistrator\RoutesProvider;

class RoutesProviderFactory
{
    public function __invoke(ContainerInterface $container): RoutesProvider
    {
        return new RoutesProvider(
            $container->get(HandlersFinder::class),
            $container->get(ConfigInterface::class),
            $container->get(RouteGenerator::class)
        );
    }
}