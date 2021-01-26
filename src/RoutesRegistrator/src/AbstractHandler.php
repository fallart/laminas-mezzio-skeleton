<?php
declare(strict_types=1);

namespace RoutesRegistrator;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractHandler implements RequestHandlerInterface
{
    abstract static function getDescription(): string;
    abstract static function getMethods(): array;

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