<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilderExample;

use AFaller\Psr7RoutesBuilder\ConfigInterface;

class Config implements ConfigInterface
{
    public function getRoutesDir(): string
    {
        return __DIR__ . '/Routes';
    }

    public function getNamespace(): string
    {
        return __NAMESPACE__ . '\\Routes';
    }

    public function getApiRoutesPrefix(): string
    {
        return '/api';
    }

    public function isCacheEnabled(): bool
    {
        return true;
    }
}
