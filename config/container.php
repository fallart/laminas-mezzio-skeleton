<?php

declare(strict_types=1);

use Laminas\ServiceManager\ServiceManager;

// Load configuration
$config = require __DIR__ . '/config.php';

$dependencies                       = $config['dependencies'];
$dependencies['services']['config'] = $config;
$dependencies['services'][] = $config;

// Build container
$serviceManager = new ServiceManager($dependencies);
// add it to psr interface
$serviceManager->setService(\Psr\Container\ContainerInterface::class, $serviceManager);

return $serviceManager;
