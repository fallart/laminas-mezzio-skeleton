<?php
declare(strict_types=1);

namespace Api\Routes;

use RoutesRegistrator\RoutesProvider;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexHandler implements RequestHandlerInterface
{
    private RoutesProvider $routesProvider;

    /**
     * IndexHandler constructor.
     * @param RoutesProvider $routesProvider
     */
    public function __construct(RoutesProvider $routesProvider)
    {
        $this->routesProvider = $routesProvider;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routes = [];

        foreach ($this->routesProvider->getAll() as $route) {

            $routes[] = [
                'name' => $route->getName(),
                'description' => $route->getDescription(),
                'path' => $route->getPath(),
                'methods' => $route->getMethods(),
            ];
        }

        return new JsonResponse($routes);
    }
}