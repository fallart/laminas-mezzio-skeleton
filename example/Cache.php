<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilderExample;

use AFaller\Psr7RoutesBuilder\CacheInterface;
use AFaller\Psr7RoutesBuilder\Route;

class Cache implements CacheInterface
{
    /** @var Route[] */
    private $routes;

    public function saveAll(array $routes): void
    {
        $this->routes = $routes;
    }

    public function getAll(): array
    {
        return $this->routes;
    }
}