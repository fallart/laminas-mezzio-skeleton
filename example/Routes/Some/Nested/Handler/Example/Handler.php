<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilderExample\Routes\Some\Nested\Handler\Example;

use AFaller\Psr7RoutesBuilder\Route;
use AFaller\Psr7RoutesBuilderExample\AbstractHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Handler extends AbstractHandler
{

    public static function getDescription(): string
    {
        return 'Just an example for nested handler path';
    }

    public static function getMethods(): array
    {
        return [Route::METHOD_GET];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->buildResponse([
            'some' => 'json',
            'data' => 'example',
        ]);
    }
}