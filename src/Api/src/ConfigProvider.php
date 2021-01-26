<?php

declare(strict_types=1);

namespace Api;

use RoutesRegistrator\ConfigInterface;

/**
 * The configuration provider for the Api module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider implements ConfigInterface
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
            ],
            'aliases'  => [

            ],
        ];
    }

    public function getRoutesDir(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Routes' . DIRECTORY_SEPARATOR;
    }

    public function getNamespace(): string
    {
        return __NAMESPACE__ . '\\Routes';
    }

    public function getApiRoutesPrefix(): string
    {
        return '/api';
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'api'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    public function isCacheEnabled(): bool
    {
        return false;
    }
}
