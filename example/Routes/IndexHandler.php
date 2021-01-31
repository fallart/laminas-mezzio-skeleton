<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilderExample\Routes;

use AFaller\Psr7RoutesBuilder\Route;
use AFaller\Psr7RoutesBuilderExample\AbstractHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexHandler extends AbstractHandler
{
    public static function getDescription(): string
    {
        return 'Index route';
    }

    public static function getMethods(): array
    {
        return [Route::METHOD_GET];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->buildResponse([]);
    }
}