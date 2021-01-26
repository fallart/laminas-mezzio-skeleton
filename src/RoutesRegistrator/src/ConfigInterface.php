<?php
declare(strict_types=1);

namespace RoutesRegistrator;

interface ConfigInterface
{
    public function getRoutesDir(): string;

    public function getNamespace(): string;

    public function getApiRoutesPrefix(): string;

    public function isCacheEnabled(): bool;
}