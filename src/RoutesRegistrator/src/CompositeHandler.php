<?php
declare(strict_types=1);

namespace RoutesRegistrator;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use RoutesRegistrator\Validation\DataValidatorInterface;

class CompositeHandler implements RequestHandlerInterface
{
    /** @var string  */
    private $handlerClassName;
    /** @var ContainerInterface */
    private $container;
    /** @var DataValidatorInterface */
    private $validator;
    /** @var ResponseGeneratorInterface */
    private $responseGenerator;
    /** @var LoggerInterface */
    private $logger;

    /**
     * CompositeHandler constructor.
     * @param string $handlerClassName
     * @param ContainerInterface $container
     * @param DataValidatorInterface $validator
     * @param ResponseGeneratorInterface $responseGenerator
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $handlerClassName,
        ContainerInterface $container,
        DataValidatorInterface $validator,
        ResponseGeneratorInterface $responseGenerator,
        LoggerInterface $logger
    ) {
        $this->handlerClassName = $handlerClassName;
        $this->container = $container;
        $this->validator = $validator;
        $this->responseGenerator = $responseGenerator;
        $this->logger = $logger;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var RequestHandlerInterface $handler */
        $handler = $this->container->get($this->handlerClassName);

        if ($handler instanceof AbstractHandler && null !== $handler->getPipe()) {
            $requestRules = $handler::getRequestRules();

            if (empty($requestRules)) {
                $request = $request->withParsedBody([]);
            } else {
                $requestValidationResult = $this->validator->validate(
                    $requestRules,
                    $handler->getRequestData($request)
                );

                if (!$requestValidationResult->isValid()) {
                    return $this->responseGenerator->generate($requestValidationResult->getMessages(), 422);
                }
                $request = $request->withParsedBody($requestValidationResult->getValidData());
            }

            $response = $handler->getPipe()->process($request, $handler);
            $responseRules = $handler::getResponseRules();

            if (empty($responseRules)) {
                return $handler->buildResponse([]);
            }

            $responseValidationResult = $this->validator->validate(
                $responseRules,
                $handler->getResponseData($response)
            );

            return $handler->buildResponse($responseValidationResult->getValidData());
        }

        return $handler->handle($request);
    }
}