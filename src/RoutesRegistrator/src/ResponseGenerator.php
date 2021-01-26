<?php
declare(strict_types=1);

namespace RoutesRegistrator;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class ResponseGenerator implements ResponseGeneratorInterface
{
    public function generate(array $data, int $code, array $headers = []): ResponseInterface
    {
        return new JsonResponse(
            $data,
            $code,
            $headers,
            JSON_PRETTY_PRINT
        );
    }
}