<?php
declare(strict_types=1);

namespace RoutesRegistrator;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RoutesRegistrator\Validation\DataValidatorInterface;

class CompositeHandlerFactory
{
    /** @var ContainerInterface */
    private $container;
    /** @var DataValidatorInterface */
    private $validator;
    /** @var ResponseGeneratorInterface */
    private $responseGenerator;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        ContainerInterface $container,
        DataValidatorInterface $validator,
        ResponseGeneratorInterface $responseGenerator,
        LoggerInterface $logger
    ) {
        $this->container = $container;
        $this->validator = $validator;
        $this->responseGenerator = $responseGenerator;
        $this->logger = $logger;
    }

    public function build(string $handlerName): CompositeHandler
    {
        return new CompositeHandler(
            $handlerName,
            $this->container,
            $this->validator,
            $this->responseGenerator,
            $this->logger
        );
    }
}