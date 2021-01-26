<?php
declare(strict_types=1);

namespace Api\Routes\Hotels\Oti\RoomCodes\ListAll;

use RoutesRegistrator\AbstractHandler;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\MiddlewareFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class Handler extends AbstractHandler
{
    private MiddlewareFactory $middlewareFactory;

    public function __construct(MiddlewareFactory $middlewareFactory)
    {
        $this->middlewareFactory = $middlewareFactory;
    }

    static function getDescription(): string
    {
        return 'Just some description example!';
    }

    static function getMethods(): array
    {
        return ['GET'];
    }

    public function getPipe(): MiddlewareInterface
    {
        return $this->middlewareFactory->prepare([
            ExampleMiddleware::class,
            SecondExampleMiddleware::class,
        ]);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'status' => self::class,
            'headers' => $request->getHeaders(),
        ]);
    }
}