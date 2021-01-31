<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder\Handler;

use Psr\Http\Message\ServerRequestInterface;

interface WithValidatedRequestHandlerInterface
{
    public static function getRequestRules(): array;

    public function getRequestData(ServerRequestInterface $request): array;
}
