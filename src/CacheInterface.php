<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder;

interface CacheInterface
{
    /**
     * @param Route[] $routes
     */
    public function saveAll(array $routes): void;

    /**
     * @return Route[]
     */
    public function getAll(): array;
}