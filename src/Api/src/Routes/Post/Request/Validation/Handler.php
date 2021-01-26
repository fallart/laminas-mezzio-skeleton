<?php
declare(strict_types=1);

namespace Api\Routes\Post\Request\Validation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RoutesRegistrator\AbstractHandler;
use RoutesRegistrator\Route;

class Handler extends AbstractHandler
{
    static function getDescription(): string
    {
        return 'Request validation test';
    }

    static function getMethods(): array
    {
        return [
            Route::METHOD_POST
        ];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->buildResponse($request->getParsedBody());
    }
}