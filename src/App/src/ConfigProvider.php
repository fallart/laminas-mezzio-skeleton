<?php

declare(strict_types=1);

namespace App;

use Psr\Log\LoggerInterface;
use RoutesRegistrator\ConfigInterface;
use RoutesRegistrator\ResponseGenerator;
use RoutesRegistrator\ResponseGeneratorInterface;
use RoutesRegistrator\RoutesProvider;
use RoutesRegistrator\Validation\DataValidator;
use RoutesRegistrator\Validation\DataValidatorInterface;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                RoutesProvider::class => RoutesProviderFactory::class,
            ],
            'aliases'  => [
                LoggerInterface::class => LoggerAdapter::class,
                ConfigInterface::class => \Api\ConfigProvider::class,
                ResponseGeneratorInterface::class => ResponseGenerator::class,
                DataValidatorInterface::class => DataValidator::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
