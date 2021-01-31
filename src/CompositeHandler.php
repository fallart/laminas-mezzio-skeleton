<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder;

use AFaller\Psr7RoutesBuilder\Exception\RequestValidationException;
use AFaller\Psr7RoutesBuilder\Handler\DescribedHandlerInterface;
use AFaller\Psr7RoutesBuilder\Handler\WithValidatedRequestHandlerInterface;
use AFaller\Psr7RoutesBuilder\Handler\WithValidatedResponseHandlerInterface;
use AFaller\Psr7RoutesBuilder\Validation\DataValidatorInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class CompositeHandler implements RequestHandlerInterface
{
    /** @var string */
    private $handlerClassName;
    /** @var ContainerInterface */
    private $container;
    /** @var ResponseGeneratorInterface */
    private $responseGenerator;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        string $handlerClassName,
        ContainerInterface $container
    ) {
        $this->handlerClassName = $handlerClassName;
        $this->container = $container;
        $this->responseGenerator = $container->get(ResponseGeneratorInterface::class);
        $this->logger = $container->get(LoggerInterface::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var RequestHandlerInterface $handler */
        $handler = $this->container->get($this->handlerClassName);

        try {
            $request = $this->validateRequest($request, $handler);
        } catch (RequestValidationException $requestValidationException) {
            return $this->responseGenerator->generate($requestValidationException->getValidationErrors(), 422);
        }

        $response = $this->process($request, $handler);
        $response = $this->validateResponse($response, $handler);

        return $response;
    }

    private function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($handler instanceof DescribedHandlerInterface && null !== $handler->getPipe()) {
            return $handler->getPipe()->process($request, $handler);
        }

        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ServerRequestInterface
     * @throws RequestValidationException
     */
    private function validateRequest(ServerRequestInterface $request, RequestHandlerInterface $handler): ServerRequestInterface
    {
        if ($handler instanceof WithValidatedRequestHandlerInterface) {
            $requestRules = $handler::getRequestRules();

            if (empty($requestRules)) {
                return $request->withParsedBody([]);
            }

            /** @var DataValidatorInterface $validator */
            $validator = $this->container->get(DataValidatorInterface::class);
            $requestValidationResult = $validator->validate(
                $requestRules,
                $handler->getRequestData($request)
            );

            if (!$requestValidationResult->isValid()) {
                throw new RequestValidationException($requestValidationResult->getMessages());
            }
            return $request->withParsedBody($requestValidationResult->getValidData());
        }

        return $request;
    }

    private function validateResponse(ResponseInterface $response, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($handler instanceof WithValidatedResponseHandlerInterface) {
            $responseRules = $handler::getResponseRules();

            if (empty($responseRules)) {
                return $handler->buildResponse([]);
            }

            /** @var DataValidatorInterface $validator */
            $validator = $this->container->get(DataValidatorInterface::class);
            $responseValidationResult = $validator->validate(
                $responseRules,
                $handler->getResponseData($response)
            );

            return $handler->buildResponse($responseValidationResult->getValidData());
        }

        return $response;
    }
}