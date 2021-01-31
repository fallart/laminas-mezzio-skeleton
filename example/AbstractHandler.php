<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilderExample;

use AFaller\Psr7RoutesBuilder\Handler\DescribedHandlerInterface;
use AFaller\Psr7RoutesBuilder\Handler\WithValidatedRequestHandlerInterface;
use AFaller\Psr7RoutesBuilder\Handler\WithValidatedResponseHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

abstract class AbstractHandler implements DescribedHandlerInterface, WithValidatedResponseHandlerInterface, WithValidatedRequestHandlerInterface
{

    static public function getRequestRules(): array
    {
        return [];
    }

    static public function getResponseRules(): array
    {
        return [];
    }

    public function getPipe(): ?MiddlewareInterface
    {
        return null;
    }

    public function getRequestData(ServerRequestInterface $request): array
    {
        return array_merge(
            $request->getParsedBody(),
            $request->getQueryParams()
        );
    }

    public function getResponseData(ResponseInterface $response): array
    {
        return json_decode((string)$response->getBody(), true);
    }

    public function buildResponse(array $data, int $code = 200, array $headers = []): ResponseInterface
    {
        return new JsonResponse($data, $code, $headers, JSON_PRETTY_PRINT);
    }
}