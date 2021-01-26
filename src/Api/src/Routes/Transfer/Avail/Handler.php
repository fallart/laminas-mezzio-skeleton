<?php


namespace Api\Routes\Transfer\Avail;


use RoutesRegistrator\AbstractHandler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Handler extends AbstractHandler
{

    static function getDescription(): string
    {
        return 'Bar';
    }

    static function getMethods(): array
    {
        return ['GET'];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $request->getParsedBody();

        return new JsonResponse([
            'status' => self::class,
        ]);
    }

    static public function getRequestRules(): array
    {
        return [];
    }

    static public function getResponseRules(): array
    {
        return [];
    }
}