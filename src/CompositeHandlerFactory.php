<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder;

use Psr\Container\ContainerInterface;

class CompositeHandlerFactory
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    public function build(string $handlerName): CompositeHandler
    {
        return new CompositeHandler(
            $handlerName,
            $this->container
        );
    }
}