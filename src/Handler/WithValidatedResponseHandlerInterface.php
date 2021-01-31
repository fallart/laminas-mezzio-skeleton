<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder\Handler;

use Psr\Http\Message\ResponseInterface;

interface WithValidatedResponseHandlerInterface
{
    public static function getResponseRules(): array;

    public function getResponseData(ResponseInterface $response): array;

    public function buildResponse(array $data, int $code = 200, array $headers = []): ResponseInterface;
}
